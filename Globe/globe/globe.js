import "./gl-matrix.js";
const mat4 = glMatrix.mat4;
const vec3 = glMatrix.vec3;
const vec4 = glMatrix.vec4;

function sphere2cart(point, aboveSea) {
    const lngr = (point.Longitude * Math.PI) / 180;
    const latr = (point.Latitude * Math.PI) / 180;
    const EarthRadius = 1.0;
    var clat = Math.cos(latr);
    var slat = Math.sin(latr);
    const EarthFlattening = 1.0 / 298.257223563;
    const EarthFF = (1.0 - EarthFlattening) * (1.0 - EarthFlattening);
    var C = 1.0 / Math.sqrt(clat * clat + EarthFF * slat * slat);
    var S = C * EarthFF;
    const x = (EarthRadius * C + aboveSea) * clat * Math.cos(lngr);
    const y = (EarthRadius * C + aboveSea) * clat * Math.sin(lngr);
    const z = (EarthRadius * S + aboveSea) * slat;
    return [-x, z, y];
}

function createLinesBuffer(device, r, g, b, createLines) {
    var vertexArray = [];
    function addLine(fromPoint, toPoint, aboveSea) {
        const f = sphere2cart(fromPoint, aboveSea);
        const t = sphere2cart(toPoint, aboveSea);
        vertexArray.push(f[0], f[1], f[2], 1, r, g, b, 1);
        vertexArray.push(t[0], t[1], t[2], 1, r, g, b, 1);
    }
    createLines(addLine);
    const floatVertexArray = new Float32Array(vertexArray);
    const verticesBuffer = device.createBuffer({
        size: floatVertexArray.byteLength,
        usage: GPUBufferUsage.VERTEX,
        mappedAtCreation: true,
    });
    new Float32Array(verticesBuffer.getMappedRange()).set(floatVertexArray);
    verticesBuffer.unmap();
    return verticesBuffer;
}

function createLatLngLines(device) {
    return createLinesBuffer(device, 0.0, 0.25, 0.0, addLine => {
        const bigSep = 15;
        const litSep = 1;
        for (let lat = -90; lat <= 90; lat += bigSep) {
            for (let lng = -180; lng <= 180; lng += litSep) {
                addLine({ Longitude: lng, Latitude: lat }, { Longitude: lng + litSep, Latitude: lat }, 0);
            }
        }
        for (let lng = -180; lng <= 180; lng += bigSep) {
            for (let lat = -90; lat <= 90; lat += litSep) {
                addLine({ Longitude: lng, Latitude: lat }, { Longitude: lng, Latitude: lat + litSep }, 0);
            }
        }
    });
}

function loadShpLineVertices(device, r, g, b, aboveSea, shp) {
    return createLinesBuffer(device, r, g, b, addLine => {
        for (const record of shp.Records) {
            const points = record.Points;
            for (let partI = 0; partI < record.Parts.length; partI++) {
                const pointStartI = record.Parts[partI];
                const pointEndI = partI < record.Parts.length - 1 ? record.Parts[partI + 1] : points.length;
                for (let i = pointStartI; i < pointEndI - 1; i++) {
                    addLine(points[i], points[i + 1], aboveSea);
                }
            }
        }
    });
}

let isAnimating = false; // Global flag to control animation
let animationFrameId; // Store the requestAnimationFrame ID to cancel it
let elapsedTime = 0; // Track the elapsed time
let startTime = 0;
let zoomLevel = 1.0;

// Variables to track dragging state
let isDragging = false;
let lastMouseX = 0;
let lastMouseY = 0;
let rotationX = 0;
let rotationY = 0;
let initialRotationX = 0;
let initialRotationY = 0;

export const startAnimation = () => {
    if (!isAnimating) {
        isAnimating = true;
        startTime = Date.now() / 1000 - elapsedTime; // Adjust start time to continue from pause
        animationFrameId = requestAnimationFrame(frame);
    }
};

export const stopAnimation = () => {
    isAnimating = false;
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId); // Cancel the current animation frame
    }
    elapsedTime = Date.now() / 1000 - startTime; // Save the elapsed time when stopped
};

export const resetGlobe = () => {
    rotationX = 0;
    rotationY = 0;
    elapsedTime = 0;
    startTime = Date.now() / 1000;
    frame();
};

export const updateZoom = (newZoomLevel) => {
    zoomLevel = newZoomLevel;
    frame();
};

let frame;

export const init = async (canvas) => {
    const coastlines = await (await fetch("./data/coastlines.json")).json();
    const countries = await (await fetch("./data/countries.json")).json();
    const basicVertWGSL = await (await fetch("globe.vert.wgsl")).text();
    const vertexPositionColorWGSL = await (await fetch("globe.frag.wgsl")).text();
    const adapter = await navigator.gpu.requestAdapter();
    const device = await adapter.requestDevice();

    const context = canvas.getContext("webgpu");
    const sampleCount = 4;
    const devicePixelRatio = window.devicePixelRatio || 1;
    const initWidth = canvas.clientWidth * devicePixelRatio;
    const initHeight = canvas.clientHeight * devicePixelRatio;
    canvas.width = initWidth;
    canvas.height = initHeight;
    const presentationFormat = navigator.gpu.getPreferredCanvasFormat();

    context.configure({
        device,
        format: presentationFormat,
        alphaMode: "premultiplied",
    });

    const vertexSize = 8 * 4; // 8 floats per vertex (position + color)
    const pipeline = device.createRenderPipeline({
        layout: "auto",
        vertex: {
            module: device.createShaderModule({
                code: basicVertWGSL,
            }),
            entryPoint: "main",
            buffers: [
                {
                    arrayStride: vertexSize,
                    attributes: [
                        {
                            // position
                            shaderLocation: 0,
                            offset: 0,
                            format: "float32x4",
                        },
                        {
                            // color
                            shaderLocation: 1,
                            offset: 16,
                            format: "float32x4",
                        },
                    ],
                },
            ],
        },
        fragment: {
            module: device.createShaderModule({
                code: vertexPositionColorWGSL,
            }),
            entryPoint: "main",
            targets: [
                {
                    format: presentationFormat,
                },
            ],
        },
        primitive: {
            topology: "line-list",
        },
        depthStencil: {
            depthWriteEnabled: true,
            depthCompare: "less",
            format: "depth24plus",
        },
        multisample: {
            count: sampleCount,
        },
    });

    const uniformBufferSize = 3 * (4 * 4 * 4) + 1 * (4 * 4); // 3 4x4 matrices, 1 vec4
    const uniformBuffer = device.createBuffer({
        size: uniformBufferSize,
        usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST,
    });

    const bindGroup0UniformLayout = pipeline.getBindGroupLayout(0);
    const renderPassDescriptor = {
        colorAttachments: [
            {
                view: undefined, // Assigned later
                clearValue: { r: 0.0, g: 0.0, b: 0.0, a: 1.0 },
                loadOp: "clear",
                storeOp: "store",
            },
        ],
        depthStencilAttachment: {
            view: undefined, // Assigned later
            depthClearValue: 1.0,
            depthLoadOp: "clear",
            depthStoreOp: "store",
        },
    };

    function getTransformationMatrix(t) {
        const viewMatrix = mat4.create();
        mat4.translate(viewMatrix, viewMatrix, vec3.fromValues(0, 0, -13 * zoomLevel)); // Apply zoom level
    
        // Add rotation around the y-axis (globe's axis)
        const rotationSpeed = 2.0 * Math.PI / (60.0 * 60.0 * 24.0);
        const timeSpeedup = 3000.0;
        mat4.rotate(
            viewMatrix,
            viewMatrix,
            rotationSpeed * timeSpeedup * t,
            vec3.fromValues(0, 1, 0) // Rotate around the y-axis (globe's axis)
        );
    
        const axisSpeed = 2.0 * Math.PI / (60.0 * 60.0 * 24.0 * 365.0);
        mat4.rotate(
            viewMatrix,
            viewMatrix,
            (axisSpeed * timeSpeedup * t) + Math.PI / 2.0 + rotationY,
            vec3.fromValues(0, 1, 0) // Rotate around the y-axis (vertical axis)
        );
        mat4.rotate(
            viewMatrix,
            viewMatrix,
            23.5 * (Math.PI / 180) + rotationX,
            vec3.fromValues(1, 0, 1) // Rotate around the x-axis (horizontal axis)
        );
    
        return viewMatrix;
    }     

    const coastlinesVerticesBuffer = loadShpLineVertices(device, 0.2, 1.0, 0.2, 0.0002, coastlines);
    const countriesVerticesBuffer = loadShpLineVertices(device, 0.0, 0.5, 0.0, 0.0001, countries);
    const latlngVerticesBuffer = createLatLngLines(device);

    let renderTarget = undefined;
    let renderTargetView = undefined;
    let depthTexture = undefined;
    let depthTextureView = undefined;

    function resizeBuffersIfNeeded() {
        let currentWidth = canvas.clientWidth * devicePixelRatio;
        let currentHeight = canvas.clientHeight * devicePixelRatio;
        const maxTextureSize = device.limits.maxTextureDimension2D;
        const scaleX = currentWidth > maxTextureSize ? maxTextureSize / currentWidth : 1;
        const scaleY = currentHeight > maxTextureSize ? maxTextureSize / currentHeight : 1;
        const scale = Math.min(scaleX, scaleY);
        currentWidth = Math.round(scale * currentWidth);
        currentHeight = Math.round(scale * currentHeight);

        if ((currentWidth !== canvas.width || currentHeight !== canvas.height || renderTarget === undefined || depthTexture === undefined) &&
            currentWidth && currentHeight) {
            if (renderTarget !== undefined) {
                renderTarget.destroy();
            }
            if (depthTexture !== undefined) {
                depthTexture.destroy();
            }
            canvas.width = currentWidth;
            canvas.height = currentHeight;
            renderTarget = device.createTexture({
                size: [canvas.width, canvas.height],
                sampleCount,
                format: presentationFormat,
                usage: GPUTextureUsage.RENDER_ATTACHMENT,
            });
            renderTargetView = renderTarget.createView();
            depthTexture = device.createTexture({
                size: [canvas.width, canvas.height],
                sampleCount,
                format: "depth24plus",
                usage: GPUTextureUsage.RENDER_ATTACHMENT,
            });
            depthTextureView = depthTexture.createView();
        }
    }

    frame = async function() {
        resizeBuffersIfNeeded();
        const t = isAnimating ? Date.now() / 1000 - startTime : elapsedTime;

        const aspect = canvas.width / canvas.height;
        const projectionMatrix = mat4.create();
        mat4.perspective(projectionMatrix, Math.PI / 20, aspect, 0.1, 100.0);

        const modelViewMatrix = getTransformationMatrix(t);
        const normModelViewMatrix = mat4.copy(mat4.create(), modelViewMatrix);
        normModelViewMatrix[12] = 0;
        normModelViewMatrix[13] = 0;
        normModelViewMatrix[14] = 0;
        mat4.invert(normModelViewMatrix, normModelViewMatrix);
        mat4.transpose(normModelViewMatrix, normModelViewMatrix);

        device.queue.writeBuffer(
            uniformBuffer,
            0,
            modelViewMatrix,
            0,
            16
        );
        device.queue.writeBuffer(
            uniformBuffer,
            64,
            projectionMatrix,
            0,
            16
        );
        device.queue.writeBuffer(
            uniformBuffer,
            2 * 64,
            normModelViewMatrix,
            0,
            16
        );

        device.queue.writeBuffer(uniformBuffer, 3 * 64, vec4.fromValues(0.0, 0.0, 1.0, 1.0), 0, 4);
        renderPassDescriptor.colorAttachments[0].view = renderTargetView;
        renderPassDescriptor.colorAttachments[0].resolveTarget = context.getCurrentTexture().createView();
        renderPassDescriptor.depthStencilAttachment.view = depthTextureView;
        const commandEncoder = device.createCommandEncoder();
        const passEncoder = commandEncoder.beginRenderPass(renderPassDescriptor);
        passEncoder.setPipeline(pipeline);
        const uniformBindGroup = device.createBindGroup({
            layout: bindGroup0UniformLayout,
            entries: [
                {
                    binding: 0,
                    resource: {
                        buffer: uniformBuffer,
                    },
                },
            ],
        });
        passEncoder.setBindGroup(0, uniformBindGroup);
        function drawVerts(verts) {
            passEncoder.setVertexBuffer(0, verts);
            passEncoder.draw(verts.size / vertexSize, 1, 0, 0);
        }

        drawVerts(coastlinesVerticesBuffer);
        drawVerts(countriesVerticesBuffer);
        drawVerts(latlngVerticesBuffer);

        passEncoder.end();
        device.queue.submit([commandEncoder.finish()]);

        if (isAnimating) {
            animationFrameId = requestAnimationFrame(frame); // Request the next frame if animating
        }
    };

    // Initialize the animation
    resizeBuffersIfNeeded();
    frame();

    // Add event listeners for dragging
    canvas.addEventListener("mousedown", (e) => {
        isDragging = true;
        lastMouseX = e.clientX;
        lastMouseY = e.clientY;
        initialRotationX = rotationX;
        initialRotationY = rotationY;
    });

    canvas.addEventListener("mousemove", (e) => {
        if (isDragging) {
            const deltaX = e.clientX - lastMouseX;
            const deltaY = e.clientY - lastMouseY;
            rotationY = initialRotationY + deltaX * 0.01;
            rotationX = initialRotationX + deltaY * 0.01;
            frame(); // Redraw with updated rotation
        }
    });

    canvas.addEventListener("mouseup", () => {
        isDragging = false;
    });

    canvas.addEventListener("mouseleave", () => {
        isDragging = false;
    });
};

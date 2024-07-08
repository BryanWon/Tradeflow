<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Matplotlib with PyScript</title>
    <link rel="stylesheet" href="https://pyscript.net/latest/pyscript.css">
    <script defer src="https://pyscript.net/latest/pyscript.js"></script>
</head>
<body>
    <h1>Matplotlib Plot with PyScript</h1>
    <div id="output"></div>

    <py-script>
        import asyncio
        import micropip

        async def install_packages():
            await micropip.install("numpy")
            await micropip.install("matplotlib")
            await micropip.install("h5netcdf")
            await micropip.install("h5py")

        asyncio.ensure_future(install_packages())
    </py-script>

    <!-- Python code to plot the data -->
    <py-script output="output">
        import asyncio

        async def main():
            import numpy as np
            import matplotlib.pyplot as plt
            import h5netcdf
            import base64
            from io import BytesIO

            # Base64 encoded NetCDF file content
            netcdf_data = """
            PASTE_YOUR_BASE64_ENCODED_STRING_HERE
            """

            # Function to read and process NetCDF data for a specific variable
            def read_netcdf_variable(dataset, variable_name):
                try:
                    time = dataset.variables['time'][:]
                    longitude = dataset.variables['longitude'][:]
                    latitude = dataset.variables['latitude'][:]
                    variable_data = dataset.variables[variable_name][:]

                    # Handle missing values
                    fill_value = dataset.variables[variable_name]._FillValue
                    variable_data = np.ma.masked_equal(variable_data, fill_value)

                    # Apply scale factor and add offset if they exist
                    scale_factor = dataset.variables[variable_name].scale_factor if hasattr(dataset.variables[variable_name], 'scale_factor') else 1.0
                    add_offset = dataset.variables[variable_name].add_offset if hasattr(dataset.variables[variable_name], 'add_offset') else 0.0

                    variable_data = variable_data * scale_factor + add_offset

                    return time, longitude, latitude, variable_data

                except Exception as e:
                    print(f"Error reading NetCDF file for variable {variable_name}: {e}")
                    return None, None, None, None

            # Plot data on a 2D map using matplotlib
            def plot_variable(dataset, variable_name):
                time, longitude, latitude, variable_data = read_netcdf_variable(dataset, variable_name)
                if longitude is None or latitude is None or variable_data is None:
                    print(f"Invalid data for {variable_name}, cannot plot.")
                    return

                variable_first_step = variable_data[0]

                plt.figure(figsize=(10, 8))
                plt.contourf(longitude, latitude, variable_first_step, cmap='viridis')
                plt.colorbar(label=f'{variable_name} (units)')
                plt.title(f'{variable_name} at time step 0')
                plt.xlabel('Longitude')
                plt.ylabel('Latitude')
                plt.show()

            # Decode the base64 encoded NetCDF data
            decoded_data = base64.b64decode(netcdf_data)
            with h5netcdf.File(BytesIO(decoded_data), 'r') as dataset:
                # Variables to plot
                variables = ['VHM0', 'VHM0_WW', 'VTM01_SW1', 'VTM01_SW2', 'VTM10', 'VHM0_SW1', 'VHM0_SW2', 'VTPK', 'VSDX', 'VSDY', 'VCMX', 'VTM02', 'VTM01_WW', 'VMDR_WW', 'VMDR_SW1', 'VMDR_SW2', 'VMDR', 'VPED']

                for variable in variables:
                    plot_variable(dataset, variable)

        asyncio.ensure_future(main())
    </py-script>
</body>
</html>

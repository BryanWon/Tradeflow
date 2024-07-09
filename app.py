from flask import Flask, render_template, jsonify, request
from flask_cors import CORS
import netCDF4 as nc

app = Flask(__name__)
CORS(app)

@app.route('/')
def home():
    return render_template('test.html')

@app.route('/data', methods=['POST'])
def data():
    # Path to the NetCDF file
    file_path = r"C:\work\mfwamglocep_2024071012_R20240702_12H.nc"  # Use raw string

    # Read NetCDF data
    dataset = nc.Dataset(file_path)
    longitude = dataset.variables['longitude'][:].tolist()
    latitude = dataset.variables['latitude'][:].tolist()

    # Get the variable to plot from the request
    variable_name = request.json.get('variable', 'VHM0')

    # Check if the variable exists in the dataset
    if variable_name not in dataset.variables:
        return jsonify({
            'error': f"Variable {variable_name} not found in the dataset."
        }), 400

    variable_data = dataset.variables[variable_name][0, :, :].tolist()  # Adjust as necessary

    return jsonify({
        'longitude': longitude,
        'latitude': latitude,
        'variable_data': variable_data,
        'variable_name': variable_name
    })

if __name__ == '__main__':
    app.run(debug=True)

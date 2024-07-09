import netCDF4 as nc

file_path = r"C:\work\mfwamglocep_2024071012_R20240702_12H.nc"

dataset = nc.Dataset(file_path)
variables = list(dataset.variables.keys())

print("Variables in the NetCDF file:", variables)

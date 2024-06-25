package com.tradeflow.common.readers;

import ucar.nc2.NetcdfFile;
import ucar.nc2.dataset.NetcdfDatasets;

import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

public class NetCDFConverter {

    public static void main(String[] args) {
        try {
            try (var ncFile = NetcdfDatasets.openDataset("/Users/tongwei/Documents/work/csvreader/src/main/resources/static/test.nc")) {

                // Read data from NetCDF file
                var netcdfData = extractDataFromNetCDF(ncFile);

                // Convert data to JSON
                String jsonData = convertToJSON(netcdfData);

                // Write JSON data to file
                writeJSONToFile(jsonData, "output.json");
            }

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private static Map<String, Object> extractDataFromNetCDF(NetcdfFile ncFile) throws IOException {
        var data = new HashMap<String, Object>();

        for (var variable : ncFile.getVariables()) {
            if (!variable.isScalar()) {
                data.put(variable.getFullName(), variable.read().copyToNDJavaArray());
            }
        }

        return data;
    }

    private static String convertToJSON(Map<String, Object> netcdfData) throws IOException {
        var objectMapper = new ObjectMapper();
        return objectMapper.writeValueAsString(netcdfData);
    }

    private static void writeJSONToFile(String jsonData, String fileName) {
        try (var fileWriter = new FileWriter(fileName)) {
            fileWriter.write(jsonData);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}

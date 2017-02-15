ALTER TABLE weather_stations_records ADD temperature_indoor DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD temperature_outdoor DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD humidity_indoor DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD humidity_outdoor DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD wind_speed DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD wind_azimuth DOUBLE PRECISION NOT NULL;
ALTER TABLE weather_stations_records ADD wind_gust DOUBLE PRECISION NOT NULL;

ALTER TABLE weather_stations_records ALTER pressure_absolute TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_absolute DROP DEFAULT;
ALTER TABLE weather_stations_records ALTER pressure_relative TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_relative DROP DEFAULT;

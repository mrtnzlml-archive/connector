ALTER TABLE weather_stations_records ADD temperature_indoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD temperature_outdoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD humidity_indoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD humidity_outdoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD wind_speed DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD wind_azimuth DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD wind_gust DOUBLE PRECISION;

ALTER TABLE weather_stations_records ALTER pressure_absolute TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_absolute DROP DEFAULT;
ALTER TABLE weather_stations_records ALTER pressure_absolute DROP NOT NULL;
COMMENT ON COLUMN weather_stations_records.pressure_absolute IS '(DC2Type:Pressure)';

ALTER TABLE weather_stations_records ALTER pressure_relative TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_relative DROP DEFAULT;
ALTER TABLE weather_stations_records ALTER pressure_relative DROP NOT NULL;
COMMENT ON COLUMN weather_stations_records.pressure_relative IS '(DC2Type:Pressure)';

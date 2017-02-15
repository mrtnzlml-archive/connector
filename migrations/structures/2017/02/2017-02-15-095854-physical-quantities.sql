ALTER TABLE weather_stations_records ADD temperature_indoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD temperature_outdoor DOUBLE PRECISION;
COMMENT ON COLUMN weather_stations_records.temperature_indoor IS '(DC2Type:Temperature)';
COMMENT ON COLUMN weather_stations_records.temperature_outdoor IS '(DC2Type:Temperature)';

ALTER TABLE weather_stations_records ADD humidity_indoor DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD humidity_outdoor DOUBLE PRECISION;
COMMENT ON COLUMN weather_stations_records.humidity_indoor IS '(DC2Type:Humidity)';
COMMENT ON COLUMN weather_stations_records.humidity_outdoor IS '(DC2Type:Humidity)';

ALTER TABLE weather_stations_records ADD wind_speed DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD wind_azimuth DOUBLE PRECISION;
ALTER TABLE weather_stations_records ADD wind_gust DOUBLE PRECISION;
COMMENT ON COLUMN weather_stations_records.wind_speed IS '(DC2Type:Speed)';
COMMENT ON COLUMN weather_stations_records.wind_gust IS '(DC2Type:Speed)';

ALTER TABLE weather_stations_records ALTER pressure_absolute TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_absolute DROP DEFAULT;
ALTER TABLE weather_stations_records ALTER pressure_absolute DROP NOT NULL;
COMMENT ON COLUMN weather_stations_records.pressure_absolute IS '(DC2Type:Pressure)';

ALTER TABLE weather_stations_records ALTER pressure_relative TYPE DOUBLE PRECISION;
ALTER TABLE weather_stations_records ALTER pressure_relative DROP DEFAULT;
ALTER TABLE weather_stations_records ALTER pressure_relative DROP NOT NULL;
COMMENT ON COLUMN weather_stations_records.pressure_relative IS '(DC2Type:Pressure)';

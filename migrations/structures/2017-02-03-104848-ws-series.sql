CREATE TABLE weather_stations_series (id UUID NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE UNIQUE INDEX weather_stations_series_code_uindex ON weather_stations_series (code);
COMMENT ON COLUMN weather_stations_series.id IS '(DC2Type:WeatherStationSeriesId)';

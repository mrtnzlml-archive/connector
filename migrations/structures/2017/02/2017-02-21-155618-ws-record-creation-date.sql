ALTER TABLE weather_stations_records ADD creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now();
ALTER TABLE weather_stations_records ALTER creation_date DROP DEFAULT;

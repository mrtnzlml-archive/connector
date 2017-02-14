ALTER TABLE weather_stations ADD creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now();
ALTER TABLE weather_stations ALTER creation_date DROP DEFAULT;

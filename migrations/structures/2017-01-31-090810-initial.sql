CREATE TABLE public.weather_stations_records (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:WeatherStationRecordId)
	weather_station_id UUID NOT NULL, -- (DC2Type:WeatherStationId)
	pressure_absolute INT NOT NULL,
	pressure_relative INT NOT NULL
);
COMMENT ON COLUMN weather_stations_records.id IS '(DC2Type:WeatherStationRecordId)';
COMMENT ON COLUMN weather_stations_records.weather_station_id IS '(DC2Type:WeatherStationId)';


CREATE TABLE public.weather_stations (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:WeatherStationId)
	owner_uuid UUID NOT NULL, -- (DC2Type:UserId)
	device_name VARCHAR(255) NOT NULL
);
COMMENT ON COLUMN weather_stations.id IS '(DC2Type:WeatherStationId)';
COMMENT ON COLUMN weather_stations.owner_uuid IS '(DC2Type:UserId)';


CREATE TABLE public.user_accounts (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:UserId)
	password_hash VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX user_accounts_username_uindex ON user_accounts USING BTREE (username);
COMMENT ON COLUMN user_accounts.id IS '(DC2Type:UserId)';

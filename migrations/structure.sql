CREATE TABLE public.weather_stations_records (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:WeatherStationRecordId)
	weather_station_id UUID NOT NULL, -- (DC2Type:WeatherStationId)
	data JSONB NOT NULL
);
COMMENT ON COLUMN weather_stations_records.id IS '(DC2Type:WeatherStationRecordId)';
COMMENT ON COLUMN weather_stations_records.weather_station_id IS '(DC2Type:WeatherStationId)';


CREATE TABLE public.weather_stations (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:WeatherStationId)
	device_name VARCHAR(255) NOT NULL
);
COMMENT ON COLUMN weather_stations.id IS '(DC2Type:WeatherStationId)';


CREATE TABLE public.database_structure_migrations (
	version VARCHAR(255) PRIMARY KEY NOT NULL
);


CREATE TABLE public.user_accounts (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:UserId)
	password_hash VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL
);
CREATE UNIQUE INDEX user_accounts_username_uindex ON user_accounts USING BTREE (username);
COMMENT ON COLUMN user_accounts.id IS '(DC2Type:UserId)';


CREATE TABLE public.weather_stations_user_accounts (
	-- defaults: NOT DEFERRABLE and INITIALLY IMMEDIATE
	weather_station_id UUID NOT NULL REFERENCES public.weather_stations(id) NOT DEFERRABLE INITIALLY IMMEDIATE, -- (DC2Type:WeatherStationId)
	user_account_id UUID NOT NULL REFERENCES public.user_accounts(id) NOT DEFERRABLE INITIALLY IMMEDIATE, -- (DC2Type:UserId)
	PRIMARY KEY(weather_station_id, user_account_id)
);
COMMENT ON COLUMN weather_stations_user_accounts.weather_station_id IS '(DC2Type:WeatherStationId)';
COMMENT ON COLUMN weather_stations_user_accounts.user_account_id IS '(DC2Type:UserId)';

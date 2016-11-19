CREATE TABLE public.data_sources_records (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:DataSourceRecordId)
	data_source_id UUID NOT NULL, -- (DC2Type:DataSourceId)
	data JSONB NOT NULL
);
COMMENT ON COLUMN data_sources_records.id IS '(DC2Type:DataSourceRecordId)';
COMMENT ON COLUMN data_sources_records.data_source_id IS '(DC2Type:DataSourceId)';


CREATE TABLE public.data_sources (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:DataSourceId)
	device_name VARCHAR(255) NOT NULL
);
COMMENT ON COLUMN data_sources.id IS '(DC2Type:DataSourceId)';


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

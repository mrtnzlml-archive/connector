CREATE TABLE public.data_sources_records (
	id UUID PRIMARY KEY NOT NULL,
	data_source_id UUID NOT NULL,
	data JSONB NOT NULL
);
COMMENT ON COLUMN data_sources_records.id IS '(DC2Type:DataSourceRecordId)';
COMMENT ON COLUMN data_sources_records.data_source_id IS '(DC2Type:DataSourceId)';


CREATE TABLE public.data_sources (
	id UUID PRIMARY KEY NOT NULL,
	device_name VARCHAR(255) NOT NULL
);
COMMENT ON COLUMN data_sources.id IS '(DC2Type:DataSourceId)';


CREATE TABLE public.database_structure_migrations (
	version VARCHAR(255) PRIMARY KEY NOT NULL
);

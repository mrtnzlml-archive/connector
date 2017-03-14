ALTER TABLE cameras ADD stream_identifier UUID NOT NULL DEFAULT '00000000-0000-0000-0000-000000000001';
COMMENT ON COLUMN cameras.stream_identifier IS '(DC2Type:uuid)';
ALTER TABLE cameras ALTER stream_identifier DROP DEFAULT;

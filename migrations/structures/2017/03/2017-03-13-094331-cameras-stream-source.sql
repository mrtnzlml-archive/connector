ALTER TABLE cameras ADD stream_source TEXT NOT NULL DEFAULT '';
ALTER TABLE cameras ALTER stream_source DROP DEFAULT;

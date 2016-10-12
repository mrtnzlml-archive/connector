CREATE TABLE incoming (
	id   INTEGER, -- TODO: UUID
	data JSONB
);

CREATE INDEX idxgin ON incoming USING GIN (data);

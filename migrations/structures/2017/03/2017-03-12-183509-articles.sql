CREATE TABLE articles (
	id UUID PRIMARY KEY NOT NULL,
	title VARCHAR(255) NOT NULL,
	content TEXT NOT NULL
);
COMMENT ON COLUMN articles.id IS '(DC2Type:uuid)';

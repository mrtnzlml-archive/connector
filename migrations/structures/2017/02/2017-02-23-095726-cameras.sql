CREATE TABLE public.cameras (
	id UUID PRIMARY KEY NOT NULL, -- (DC2Type:CameraId)
	owner_uuid UUID NOT NULL, -- (DC2Type:UserId)
	camera_name VARCHAR(255) NOT NULL,
	creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
);
COMMENT ON COLUMN cameras.id IS '(DC2Type:CameraId)';
COMMENT ON COLUMN cameras.owner_uuid IS '(DC2Type:UserId)';

INSERT INTO public.cameras VALUES (
	'c87c0ea0-c40f-4883-9a8f-e95ff6a66b94', -- UUID
	'00000000-0000-0000-0000-000000000001', -- owner UUID
	'Camera 1 - rooftop North', -- camera name
	CURRENT_TIMESTAMP - INTERVAL '3 hour' --creation date
), (
	'52335bb2-e7b3-4f90-8c0b-acfe408d8259', -- UUID
	'00000000-0000-0000-0000-000000000001', -- owner UUID
	'Camera 2 - rooftop South', -- camera name
	CURRENT_TIMESTAMP - INTERVAL '2 hour' --creation date
);

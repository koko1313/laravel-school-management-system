# School management system

“School Management System” online based web application for managing and representing of school grades and information in Bulgarian schools online. 
The goal of the web platform is to eliminate the paper documentation and each user (director, class teacher, teacher, student) 
to have easy and real-time access to the platform, even from their smartphones. The students will be able to check their grades, 
the information about their absences and personal notes.


## Configuration

1. Run
	```
	composer install
	```

2. Create `.env` file by copying `.env.example`. Edit the following:
	```
	APP_KEY=base64:iDvvZb0bS1MWH1JzflAty9YJYMvqpPdIO6fZMZHITdo=
	
	DB_DATABASE=...
	DB_USERNAME=...
	DB_PASSWORD=...
	
	CAPTCHA_SECRET=6Le2DaYUAAAAAFa32fUERK2FJIz9pjbfP0g9uWc9
	CAPTCHA_KEY=6Le2DaYUAAAAAAbVGVzTuwVh9OExTdYldPPii2lj
	```

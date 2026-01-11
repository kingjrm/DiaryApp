# Daily Diary Web Application

A modern, user-friendly Daily Diary Web Application built with HTML, CSS, Tailwind CSS, JavaScript, and PHP with MySQL database.

## Features

- **Secure Authentication**: Login and registration with email-based OTP verification via SMTP
- **Session Management**: Secure session-based authentication with password hashing
- **Diary Management**: Create, edit, delete, and view diary entries
- **Calendar View**: Interactive calendar-based UI for navigating entries
- **Timeline View**: Chronological display of all diary entries
- **Search Functionality**: Search entries by title or content
- **Image Uploads**: Multiple image uploads per entry with drag-and-drop, preview, and validation
- **Mood Tags**: Add mood indicators to entries
- **Auto-save**: Automatic saving of drafts
- **Responsive Design**: Mobile-friendly interface
- **Modern UI**: Glassmorphism and neumorphism-inspired design with smooth animations

## Installation

1. **Prerequisites**:
   - XAMPP (or similar PHP/MySQL environment)
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Composer (for PHP dependencies)

2. **Setup**:
   - Clone or download the project to `C:\xampp\htdocs\DiaryApp`
   - Start XAMPP and ensure Apache and MySQL are running

3. **Database Setup**:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `diary_app`
   - Import the `schema.sql` file (this will create a default user: admin@example.com / password)

4. **Configuration**:
   - Update `.env` file with your SMTP credentials and other settings
   - Ensure the `public/uploads` directory is writable

5. **Access the Application**:
   - Open your browser and go to `http://localhost/DiaryApp/public`

## Project Structure

```
DiaryApp/
├── public/                 # Public web root
│   ├── index.php          # Main entry point
│   ├── assets/            # Static assets
│   ├── js/                # JavaScript files
│   ├── css/               # CSS files
│   └── uploads/           # Uploaded images
├── app/
│   ├── controllers/       # Controller classes
│   ├── models/            # Model classes
│   └── views/             # View templates
│       ├── auth/          # Authentication views
│       ├── diary/         # Diary views
│       └── components/    # Reusable components
├── config/                # Configuration files
├── storage/               # Temporary files and logs
├── vendor/                # Third-party libraries (PHPMailer)
├── .env                   # Environment configuration
└── schema.sql            # Database schema
```

## Security Features

- Password hashing with bcrypt
- CSRF protection
- Prepared statements for SQL queries
- Input validation and sanitization
- Session security
- File upload validation

## Technologies Used

- **Frontend**: HTML5, CSS3, Tailwind CSS, JavaScript (ES6+)
- **Backend**: PHP 7.4+, MySQL
- **Libraries**: PHPMailer for email, Tailwind CSS for styling
- **Architecture**: MVC pattern with custom router

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is for educational purposes. Please ensure you comply with all applicable laws and regulations when using this code.

## Support

For issues or questions, please check the code comments or create an issue in the repository.
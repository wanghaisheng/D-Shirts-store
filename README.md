D-shirts

D-shirts is a tech-themed T-shirt store built as a portfolio project to showcase my skills as a Laravel developer. The project is live at d-shirts.galdi.dev and is open source, allowing anyone to clone, customize, and host their own version.

Tech Stack

VILT Stack: Laravel, Inertia, Vue, and Tailwind CSS.

PrimeVue: For UI components.

Stripe: Integrated for payment processing.

Resend: For sending emails.

Deployment: Deployed on a LEMP server hosted on DigitalOcean.

Features

User Features

Browse and purchase tech-themed T-shirts.

Responsive design for seamless use across devices.

Secure payment processing using Stripe.

Admin Dashboard

Orders: View incoming orders and mark them as fulfilled.

Customers: Access and manage customer information.

T-shirt Management: Add, edit, and delete T-shirts with their images.

Revenue Section: View revenue and order analytics through charts for different time periods.

What I Learned

This project was a significant learning experience where I:

Used Inertia.js for the first time.

Combined Vue.js with Laravel for a seamless frontend-backend interaction.

Implemented Stripe for payment integration.

Configured Laravel for email sending using Resend.

Utilized Laravel queue jobs for asynchronous tasks.

Installation

To set up your own version of D-shirts, follow these steps:

Clone the repository:

git clone https://github.com/your-repo-url.git
cd d-shirts

Install dependencies:

composer install
npm install

Set up the environment variables by copying .env.example to .env:

cp .env.example .env

Update the .env file with your own API keys for Stripe and Resend:

# Resend Configuration
RESEND_API_KEY=re_abc
MAIL_MAILER=resend
MAIL_FROM_ADDRESS=d-shirts@galdi.dev
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=null
ADMIN_EMAIL=contact.galdi@gmail.com

# Stripe Configuration
STRIPE_KEY=pk_test_abc
STRIPE_SECRET=sk_test_abc
STRIPE_WEBHOOK_SECRET=whsec_abc

Set up the database:

php artisan migrate --seed

This will run migrations and seed the database with predefined data.

Build the frontend assets:

npm run build

Serve the application:

php artisan serve

Open the application in your browser:
http://localhost:8000

Screenshots

Add screenshots here for the homepage and admin dashboard.

License

This project is open source and available under the MIT License.
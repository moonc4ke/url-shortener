# URL Shortener Project

This README provides instructions on how to set up and launch the URL Shortener project using Laravel, Vue.js, and SQLite.

## Prerequisites

- PHP (>= 8.0)
- Composer
- Node.js (>= 12)
- npm or Yarn
- SQLite

## Step-by-Step Setup

1. **Clone the Repository**
```bash
   git clone https://github.com/moonc4ke/url-shortener.git
   cd url-shortener
```

2. **Install PHP Dependencies**
```bash
   composer install
```

3. **Install JavaScript Dependencies**
```bash
   npm install
```

4. **Set Up Environment Variables**
```bash
   cp .env.example .env
```
* 4.1 Update your `.env` file with the necessary database and app settings:
```bash
    APP_NAME=URLShortener
    APP_ENV=local
    APP_KEY=base64
    APP_DEBUG=true
    APP_URL=http://localhost
    DB_CONNECTION=sqlite
    DB_DATABASE=/full/path/to/your/database/url_shortener.sqlite
```

5. **Generate Application Key**
```bash
    php artisan key
```

6. **Run Migrations**
```bash
    php artisan migrate
```

7. **Run the Development Server**
```bash
    php artisan serve
```

8. **Run the Frontend Development Server**
```bash
    npm run dev
```


## Usage

- Open your browser and navigate to `http://localhost:8000`.
- Enter a URL in the input field and click "Shorten". The application will generate a short URL.
- Access the shortened URLs using the generated short link.

## Directory Structure

- `app/Http/Controllers/UrlController.php`: Main controller for URL shortening and redirection.
- `app/Models/Url.php`: URL model.
- `database/migrations`: Directory containing migration files.
- `resources/js/Pages/Home.vue`: Vue component for the homepage.
- `routes/web.php`: The routes file.

## Additional Notes

- Ensure you have set the correct path to your SQLite database in the `.env` file.
- Make sure to obtain a Google Safe Browsing API key and set it in the `.env` file.

# Portfolio v2  

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![Supabase](https://img.shields.io/badge/Supabase-3ECF8E?style=flat&logo=supabase&logoColor=white)  

<img width="1697" height="906" alt="image" src="https://github.com/user-attachments/assets/53dc54b1-1459-461d-89f8-77e8adc9725b" />  

The second version of my personal portfolio website, built with PHP, JavaScript, HTML, and CSS, backed by a Supabase database.  

**Live site:** [nathangeers.com](https://nathangeers.com)  

## Features

- Responsive design across desktop, tablet, and mobile
- Dynamic content powered by a Supabase backend
- Clean, fast-loading UI built with vanilla HTML/CSS/JS
- PHP-driven server-side logic
- Contact form using EmailJS
- Light-Dark mode toggle.

## Tech Stack

- **Backend:** PHP
- **Frontend:** HTML, CSS, JavaScript
- **Database:** Supabase

## Folder Structure

```
portfolio-v2/
├── public/    
│   ├── index.php
│   ├── about.php
│   ├── contact.php
│   ├── project.php
│   ├── projects.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
├── includes/
│   ├── navbar.php
│   ├── project_card.php
│   ├── project_card_featured.php
│   ├── career.php
├── data/
├── .env
└── README.md
```

## Getting Started

### Prerequisites

- PHP 8.x or higher
- A local web server (e.g. Apache, Nginx, or PHP's built-in server)
- A [Supabase](https://supabase.com) project (URL + API key)

### Installation

1. Clone the repository
   ```bash
   git clone https://github.com/NathanGrs00/portfolio-v2.git
   cd portfolio-v2
   ```

2. Set up environment variables
   Create a .env file at the root and fill in your Supabase credentials:
   ```
   SUPABASE_URL=your_supabase_url
   SUPABASE_KEY=your_supabase_api_key
   ```

3. Run a local server
   ```bash
   php -S localhost:8000 -t public
   ```

4. Visit `http://localhost:8000` in your browser

This project is currently deployed at [nathangeers.com](https://nathangeers.com).

## Contributors

- [**Nathan Geers**](https://github.com/NathanGrs00)

Contributions, issues, and suggestions are welcome. Feel free to open a pull request or issue.

## License

This project is licensed under this [License](LICENSE).

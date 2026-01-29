<h1>PokeClima</h1>

A weather dashboard that maps real-time weather conditions to Pokémon sprites. I built this project to practice full-stack development using PHP, MySQL, and external API integration.

The app fetches weather data for specific cities and dynamically updates the markers on the map. For example, if it's raining in London, you'll see a Politoed; if it's sunny in Madrid, you'll see an Eevee.

<img width="1848" height="884" alt="image" src="https://github.com/user-attachments/assets/648f9d99-ee73-4a0c-97cc-963b7ed4883a" />

<h2>Features</h2>

* **Interactive Map:** Browsable map based on Leaflet.js with custom markers.
* **Weather-to-Pokémon Logic:** A backend script checks the weather condition (Rain, Clouds, Clear, etc.) and assigns a matching Pokémon from the database.
* **User Accounts:** Secure registration and login system to save user preferences.
* **Favorites System:** Logged-in users can pin their favorite cities to the dashboard for quick access.
* **Admin Panel:** A dedicated interface to add new cities by simply clicking coordinates on the map or deleting existing ones.
* **Security:** Implements password hashing and prepared statements to prevent SQL injection.

<h2>Tech Stack</h2>

* **Frontend:** HTML5, CSS3, JavaScript (jQuery + Leaflet.js).
* **Backend:** Native PHP.
* **Database:** MySQL.
* **APIs:** OpenWeatherMap (Weather data) & PokemonDB (Sprites).

<h2>How to Set Up</h2>

1.  **Clone the repo** to your local server folder (e.g., `htdocs` in XAMPP).
2.  **Database Config:**
    * Open `includes/db.php` and check your database credentials (host, user, password).
3.  **Run the Installer:**
    * Open your browser and go to `http://localhost/pokeclima/install.php`.
    * This script will automatically create the database tables and seed them with initial data (default cities and Pokemon mappings).
4.  **API Key:**
    * Get a free API Key from [OpenWeatherMap](https://openweathermap.org/).
    * Open `api_clima.php` and replace the `$api_key` variable with your own key.
    * (As of right now, the project uses my api key, it will later be replaced)
5.  **Done!** Go to `index.php` and start using the app.

<h2>Project Structure</h2>

* `admin.php` - Panel for managing locations.
* `api_favorites.php` - Logic for adding your favorite cities
* `api_clima.php` - The core logic that talks to the Weather API.
* `install.php` - One-time script to set up the DB.
* `index.php` - The main page
* `login_form.php` - Form for login
* `register_form.php` - Form for registering a user
* `logout.php` - Exiting the session
* `js/app.js` - Handles the map rendering and AJAX calls.
* `css/style.css` - Custom styling.
* `includes/db.php` - Creating the connection with the database.

<h2>Credits</h2>

* Map tiles by OpenStreetMap.
* Pokémon sprites courtesy of PokemonDB.
* Weather data provided by OpenWeatherMap.

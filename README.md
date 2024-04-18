# Examen de Méthodologie de test

## Démarrage rapide

1. Cloner le projet
   ```Shell
      git clone git@github.com:Narigane3/art-app-methodo-test.git
      ```
2. Installer les dépendances
   ```Shell
    npm install
   composer install
    ```
3. Copier le fichier .env.example en .env
   ```Shell
   cp .env.example .env
   ```
4. Générer les clés de l'application
   ```Shell
    php artisan key:generate
    ```
5. Activer le cache de l'application
   ```Shell
    php artisan config:cache
    ```
6. Activer les lien symboliques
   ```Shell
    php artisan storage:link
   ```
7. Démarrer le serveur dans docker
   ```Shell
    ./vendor/bin/sail up -d
   ```
8. Exécuter les migrations
   ```Shell
    ./vendor/bin/sail artisan migrate
   ```

9. Lancez les tests
   ```Shell
    ./vendor/bin/sail artisan test
   ```

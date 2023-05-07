## Zadanie na zaliczenie z baz danych

### Instrukcja uruchomienia

2. Pobierz repo
2. Wypakuj pliki
3. Otwórz konsole w głównym katalogu projektu
4. Użyj poniższego polecenia aby zbudować obrazy i kontener

```
docker-compose -p example-app up -d
```

5. Wejdź na `http://localhost:8001/` i zaznacz zgody

Po wykonaniu komendy aplikacja powinna zacząć działać i być dostępna pod url http://localhost:8080/.

Aplikacja nie zawiera frontu tylko api.

### Adresy URL

Strona: http://localhost:8080
Redis port: http://localhost:6379/
Redis stack: http://localhost:8001/redis-stack/browser

### Endpoint domeny

Url: http://localhost:8080/api/domain/

#### POST

Umożliwia dodanie/modyfikcję rekordu klucz nazwa domeny. W przypadku erroru w response zakodwane w json error, w
przypadku sukcesu success true.
Domain wymagane. Maksymalna ilość parametrów 10.

```
http://localhost:8080/api/domain/
```

```json
{
  "domain": "example.com",
  "type": "A",
  "value": "192.0.2.1"
}
```

#### GET

Umożliwia pobranie pojedynczej domeny lub listy domen.

```
http://localhost:8080/api/domain/
```

```
http://localhost:8080/api/domain/?domain=example.com
```

#### DELETE

Umożliwia usunięcie pojedynczej domeny, wymaga payloadu z kluczem domain.

```
http://localhost:8080/api/domain/
```

```json
{
  "domain": "example.com"
}
```

### Endpoint zgłaszania problemów

Url: http://localhost:8080/api/report/

#### POST

Umożliwia podbicie licznika danej domeny.

```
http://localhost:8080/api/report/
```

```json
{
  "domain": "example.com"
}
```

#### GET

Umożliwia pobranie licznika pojedynczej domeny.

```
http://localhost:8080/api/report/?domain=example.com
```

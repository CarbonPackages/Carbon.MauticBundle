# Mautic Carbon Bundle API Documentation

Extend Mautic for usage with Carbon.Mautic in Neos CMS

## API Endpoints

Here a short overview of the API endpoints available in the Mautic Carbon Bundle.

### 1. Ping Endpoint

- **Path:** `/api/ping`
- **Method:** `GET`
- **Description:** This endpoint is used to check the availability of the API. It returns a simple JSON response with a
  "ping" message.

#### 1.1 Example Request

```http
GET /api/ping HTTP/1.1
Host: your-mautic-instance.com
```

#### 1.2 Example Response

```json
{
  "success": 1,
  "ping": "pong"
}
```

### 2. Send Example Email

- **Path:** `/api/emails/{id}/example`
- **Method:** `POST`
- **Description:** This endpoint sends example emails to specified recipients. The email ID must be provided in the
  path.

#### 2.1 Example Request

```http
POST /api/emails/123/example HTTP/1.1
Host: your-mautic-instance.com
Content-Type: application/json

{
    "recipients": ["example@example.com"],
    "previewForContactId": 1
}
```

#### 2.2 Example Response

```json
{
  "success": 1,
  "recipients": ["example@example.com"]
}
```

### 3. Update Email Settings

- **Path:** `/api/emails/{id}/settings`
- **Method:** `POST`
- **Description:** This endpoint updates the settings for a specific email. The email ID must be provided in the path.

#### 3.1 Example Request

```http
POST /api/emails/123/settings HTTP/1.1
Host: your-mautic-instance.com
Content-Type: application/json

{
    "settingKey": "settingValue"
}
```

#### 3.2 Example Response

```json
{
  "success": 1,
  "settings": {
    "settingKey": "settingValue"
  }
}
```

### 4. Get Email Settings

- **Path:** `/api/emails/{id}/settings`
- **Method:** `GET`
- **Description:** This endpoint retrieves the settings for a specific email. The email ID must be provided in the path.

#### 4.1 Example Request

```http
GET /api/emails/123/settings HTTP/1.1
Host: your-mautic-instance.com
```

#### 4.2 Example Response

```json
{
  "success": 1,
  "settings": {
    "settingKey": "settingValue"
  }
}
```

## Notes

- Add the API credentials to every request.
- Replace `your-mautic-instance.com` with the actual domain of your Mautic instance.
- Ensure that the email ID provided in the path is valid and exists in your Mautic instance.

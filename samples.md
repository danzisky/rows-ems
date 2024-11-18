# API Requests and Responses

## API Endpoints:

```bash
GET|HEAD        api/certifications ......... API\CertificationController@index  
GET|HEAD        api/employees ................... API\EmployeeController@index  
POST            api/employees ................... API\EmployeeController@store  
GET|HEAD        api/employees/{employee} ......... API\EmployeeController@show  
PUT             api/employees/{employee} ....... API\EmployeeController@update  
DELETE          api/employees/{employee} ...... API\EmployeeController@destroy
```

## 1. Get Employees (GET Request)
### Request:
```http
GET /api/employees HTTP/1.1
Host: localhost:8000
Accept: application/json
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: HHVIxmS3hWJrVxMa8Bwxh0wER90q05BmkLPiEtVu
```
### Response:

```json
{
  "status": 200,
  "statusText": "OK",
  "headers": {
    "cache-control": "no-cache, private",
    "connection": "close",
    "content-type": "application/json",
    "date": "Mon, 18 Nov 2024 09:34:53 GMT, Mon, 18 Nov 2024 09:34:53 GMT",
    "host": "localhost:8000",
    "vary": "Origin",
    "x-powered-by": "PHP/8.1.6",
    "x-ratelimit-limit": "60",
    "x-ratelimit-remaining": "57"
  },
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Summer Botsford",
        "email": "augusta06@example.com",
        "phone_number": "276.322.3659",
        "job_title": "Precious Stone Worker",
        "salary": 47537.36,
        "created_at": "2024-11-17T19:11:42.000000Z",
        "updated_at": "2024-11-17T19:11:42.000000Z"
      },
    ],
    "first_page_url": "http://localhost:8000/api/employees?page=1",
    "from": 1,
    "last_page": 2,
    "last_page_url": "http://localhost:8000/api/employees?page=2",
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/employees?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http://localhost:8000/api/employees?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http://localhost:8000/api/employees?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "next_page_url": "http://localhost:8000/api/employees?page=2",
    "path": "http://localhost:8000/api/employees",
    "per_page": 6,
    "prev_page_url": null,
    "to": 6,
    "total": 12
  }
}
```

## 2. Get Certifications (GET Request)
### Request:
```http
GET /api/certifications HTTP/1.1
Host: localhost:8000
Accept: application/json
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: HHVIxmS3hWJrVxMa8Bwxh0wER90q05BmkLPiEtVu
```
### Response:

```json
{
  "status": 200,
  "statusText": "OK",
  "headers": {
    "cache-control": "no-cache, private",
    "connection": "close",
    "content-type": "application/json",
    "date": "Mon, 18 Nov 2024 09:35:24 GMT, Mon, 18 Nov 2024 09:35:24 GMT",
    "host": "localhost:8000",
    "vary": "Origin",
    "x-powered-by": "PHP/8.1.6",
    "x-ratelimit-limit": "60",
    "x-ratelimit-remaining": "56"
  },
  "data": [
    {
      "id": 1,
      "name": "Project Management Professional (PMP)",
      "created_at": "2024-11-17T19:11:42.000000Z",
      "updated_at": "2024-11-17T19:11:42.000000Z"
    },
  ]
}
```

## 3. Create Employee (POST Request)
### Request:
```http
POST /api/employees HTTP/1.1
Host: localhost:8000
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: HHVIxmS3hWJrVxMa8Bwxh0wER90q05BmkLPiEtVu
```
### Data:
```json
{
  "name": "Daniel Rood",
  "job_title": "Developer",
  "email": "dannie005@gmail.co",
  "salary": 200,
  "phone_number": "0743882193",
  "certifications": [4]
}
```
### Response:
```json
{
  "status": 200,
  "statusText": "OK",
  "headers": {
    "access-control-allow-credentials": "true",
    "access-control-allow-origin": "http://localhost:8000",
    "cache-control": "no-cache, private",
    "connection": "close",
    "content-type": "application/json",
    "date": "Mon, 18 Nov 2024 09:36:40 GMT, Mon, 18 Nov 2024 09:36:40 GMT",
    "host": "localhost:8000",
    "vary": "Origin",
    "x-powered-by": "PHP/8.1.6",
    "x-ratelimit-limit": "60",
    "x-ratelimit-remaining": "57"
  },
  "data": {
    "message": "Employee created successfully"
  }
}
```

## 4. Update Employee (PUT Request)
### Request:
```http
PUT /api/employees/18 HTTP/1.1
Host: localhost:8000
Accept: application/json
Content-Type: application/json
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: HHVIxmS3hWJrVxMa8Bwxh0wER90q05BmkLPiEtVu
```
### Data:
```json
{
  "id": 18,
  "name": "Daniel Rood",
  "email": "dannie005@gmail.co",
  "phone_number": "0743882193",
  "job_title": "Developer",
  "salary": 200,
  "created_at": "2024-11-18T09:36:40.000000Z",
  "updated_at": "2024-11-18T09:36:40.000000Z",
  "certifications": [4]
}
```
### Response:
```json
{
  "status": 200,
  "statusText": "OK",
  "headers": {
    "access-control-allow-credentials": "true",
    "access-control-allow-origin": "http://localhost:8000",
    "cache-control": "no-cache, private",
    "connection": "close",
    "content-type": "application/json",
    "date": "Mon, 18 Nov 2024 09:37:40 GMT, Mon, 18 Nov 2024 09:37:40 GMT",
    "host": "localhost:8000",
    "vary": "Origin",
    "x-powered-by": "PHP/8.1.6",
    "x-ratelimit-limit": "60",
    "x-ratelimit-remaining": "56"
  },
  "data": {
    "message": "Employee updated successfully"
  }
}
```
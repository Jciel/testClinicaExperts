# Backed for test Clinica Expert


### Dependencies:
To run the project you need to have Docker and Docker Compose installed.  
It is also necessary to have the make command already installed.


### Installing and running

First check if the Docker service is already running, with the Docker service running, enter the
project and run the command:  
```bash
make d-up
```
with this command we will download and build the Docker image.  

<br>

After finishing the process, we will set up the database, in another console, running the command:
```bash
make migrate
```

<br>

After that we have the backend running and the database created, we can add some data by seeding the database:
```bash
make db-seeder
```

<br>

### Tests
To run the tests just run the command:
```
make test
```
We can also run a specific test file:  
```
make testfile file=FileName
```
where ``FileName`` is the name of the test file we want to run.  


# API  


<details>
<summary>GET /{identifier}</summary>

```
response 200 with redirect
```
</details>

<details>
<summary>POST /v1/create</summary>

```
Request
body 
{
	"url": "https://www.google.com.br"
}

Reponse 200
{
	"identifier": "9dcaddfe7793ae",
	"urlShort": "http:\/\/localhost\/9dcaddfe7793ae",
	"url": "https:\/\/www.google.com.br",
	"id": "99fa94a3-c101-40f6-8f7c-595927d02545",
	"updated_at": "2023-08-26T01:59:06.000000Z",
	"created_at": "2023-08-26T01:59:06.000000Z"
}
```
</details>

<details>
<summary> GET /v1/list </summary>

```
Request
query 
{
	"page": 1,
	"created": "asc"
	"hits": "desc"
	"identifier": "asc"
	"url": "asc"
}

Reponse 200
{
	"current_page": 1,
	"data": [
		{
			"id": "99feaf57-1d83-4cbf-b396-923d15125624",
			"identifier": "b687497d229c7c",
			"urlShort": "http:\/\/localhost\/b687497d229c7c",
			"url": "https:\/\/www.google.com.br",
			"hits": 0,
			"created_at": "2023-08-28T02:57:04.000000Z",
			"updated_at": "2023-08-28T02:57:04.000000Z"
		}
	],
	"first_page_url": "http:\/\/localhost\/v1\/list?page=1",
	"from": 1,
	"last_page": 1,
	"last_page_url": "http:\/\/localhost\/v1\/list?page=1",
	"links": [
		{
			"url": null,
			"label": "&laquo; Previous",
			"active": false
		},
		{
			"url": "http:\/\/localhost\/v1\/list?page=1",
			"label": "1",
			"active": true
		},
		{
			"url": null,
			"label": "Next &raquo;",
			"active": false
		}
	],
	"next_page_url": null,
	"path": "http:\/\/localhost\/v1\/list",
	"per_page": 10,
	"prev_page_url": null,
	"to": 1,
	"total": 1
}
```
</details>


<details>
<summary>GET /v1/get-stats</summary>

```
Reponse 200
{
	"hits": 23,
	"links": 5
}
```
</details>

<details>
<summary>POST /v1/search</summary>

```
Request
body 
{
	"url": "https://www.google.com.br"
}

Reponse 200
[
	{
		"id": "99feaf57-1d83-4cbf-b396-923d15125624",
		"identifier": "b687497d229c7c",
		"urlShort": "http:\/\/localhost\/b687497d229c7c",
		"url": "https:\/\/www.google.com.br",
		"hits": 0,
		"created_at": "2023-08-28T02:57:04.000000Z",
		"updated_at": "2023-08-28T02:57:04.000000Z"
	},
	{
		"id": "99feaf58-1d06-4c44-89d2-a97ff3fe333d",
		"identifier": "2156d5e6bff697",
		"urlShort": "http:\/\/localhost\/2156d5e6bff697",
		"url": "https:\/\/www.google.com.br",
		"hits": 0,
		"created_at": "2023-08-28T02:57:05.000000Z",
		"updated_at": "2023-08-28T02:57:05.000000Z"
	}
]
```
</details>


<details>
<summary>PATCH /v1/update/{id}</summary>

```
Request
body 
{
	"url": "https://www.tamarindo.com.br"
}

Reponse 200
{
	"id": "99feaf57-1d83-4cbf-b396-923d15125624",
	"identifier": "b687497d229c7c",
	"urlShort": "http:\/\/localhost\/b687497d229c7c",
	"url": "https:\/\/www.tamarindo.com.br",
	"hits": 0,
	"created_at": "2023-08-28T02:57:04.000000Z",
	"updated_at": "2023-08-28T03:01:32.000000Z"
}
```
</details>

<details>
<summary>DELETE /v1/delete/{id}</summary>

```
Reponse 200
{
	"id": "99feaf57-1d83-4cbf-b396-923d15125624",
	"identifier": "b687497d229c7c",
	"urlShort": "http:\/\/localhost\/b687497d229c7c",
	"url": "https:\/\/www.tamarindo.com.br",
	"hits": 0,
	"created_at": "2023-08-28T02:57:04.000000Z",
	"updated_at": "2023-08-28T03:01:32.000000Z"
}
```
</details>

<br>
<br>

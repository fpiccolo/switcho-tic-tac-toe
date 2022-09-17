# Tic-Tac-Toe
## Install
download the repository:
`git clone git@github.com:fpiccolo/tic-tac-toe.git`

Enter into folder:
`cd tic-tac-toe`

Run make command for build containers, install vendor and run migration on database:
`make init`

If everything went as it should go, the API will be exposed to the following url:
`http://127.0.0.1:8080`

## Endpoints
### Create a new Game
This endpoint permit to start a new game and return an object with the ID of the game

Url:
`POST http://127.0.0.1:8080/game`

Example Request:
```
curl --location --request POST 'http://127.0.0.1:8080/game'
```

Example Response:
```json
{
    "id": 1,
    "winningPlayer": null,
    "completed": false,
    "moves": []
}
```
### Add a move
This enpoint permit to add a new move to a specific game:

Url:
`POST http://127.0.0.1:8080/game/{gameId}/move`

Example Request Body
```json
{
    "player": 1,
    "place": 4
}
```
Example Curl:
```
curl --location --request POST 'http://127.0.0.1:8080/game/1/move' \
--header 'Content-Type: application/json' \
--data-raw '{
    "player": 1,
    "place": 1
}'
```

Example Response:
```json
{
    "id": 1,
    "winningPlayer": null,
    "completed": false,
    "moves": [
        {
            "player": 2,
            "position": 9
        },
        {
            "player": 1,
            "position": 1
        }
    ]
}
```

In the response `completed` field show if a game is completed with a winner o without winner
In the response `winningPlayer` field show show the player that have win

The field player can have only these values: 1 and 2
The field place can hanve value from 1 to 9 that representing the positions of the playing field as in image below
![alt text](tic-tac-toe-place.jpeg)

### Exceptions
If the user send an invalid place or an invalid user or don't respect the turn ecc... the server return a error response
Examples:
```json
{
    "message": "Not valid turn for player [1]",
    "code": 400
}
```
```json
{
    "message": "Place [1] already occupied",
    "code": 400
}
```
```json
{
    "message": "Place [12] is not valid",
    "code": 400
}
```

[Rus version](README.md)

### Given:
Three repositories:
- database (mysql),
- cache (redis)
- API (http)

### Necessary:
Return data from storage by user id

### Conditions:
- If the data is in the cache - return from the cache.
- If there is no data in the cache, then take it from the database, then cache it and return it.
- If the data is neither in the cache nor in the database, then take it from the API, save it in the database, cache it and return it.
- There is always data in the API.

It is not necessary to implement connections to storages and directly requests to them, empty methods in classes are enough.

### Launch
```
php index.php
```

### Note
See also [Tanuki](../Tanuki/README.ENG.MD) - here is a completely similar task
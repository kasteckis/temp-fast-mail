# Self Hosted Temporary Fast Email Box

First self-hosted temporary fast email box which receives emails and displays them.

![Temp Fast Mail frontpage photo](https://github.com/kasteckis/temp-fast-mail/blob/master/image.png?raw=true)

<b>You can checkout working DEMO: [TempFastMail.com](https://tempfastmail.com)</b>


## How to set up with Docker Compose?

1. Create docker-compose.yml file with following content. Also adjust environment variables as needed.

```
services:
  tempfastmail:
    container_name: kasteckis_tempfastmail
    image: kasteckis/temp-fast-mail:latest
    environment:
      CREATE_RECEIVED_EMAIL_API_AUTHORIZATION_KEY: change-this-to-a-random-value # TODO: Create random value here!
      DEFAULT_URI: https://yourdomain.com # TODO: Change to your domain!
    ports:
      - "80:80"
    volumes:
      - ./sqlite:/app/sqlite
```

2. Set up CloudFlare Email Worker (<b>It's free</b>) which would publish received emails to your instance. [You can follow instructions here](https://github.com/kasteckis/temp-fast-mail/blob/master/docs/CLOUDFLARE_EMAIL_WORKER_SETUP.md).
3. Visit your website and start receiving emails!

## How we create production image?
```
$ docker build --target frankenphp_prod -t kasteckis/temp-fast-mail:latest .
$ docker push kasteckis/temp-fast-mail:latest
```

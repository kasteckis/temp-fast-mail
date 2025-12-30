ssh:
	docker exec -it tempfastmail_php bash
deploy-prod:
	docker compose -f docker-compose.prod.yaml build --pull --no-cache && docker compose stop php && docker compose -f docker-compose.prod.yaml up --wait

Morten Portfolio 3.2 - Translation Provider Manager
====================================================

New translation engines
-----------------------
- Manual: uses the English fields without automatic translation.
- LibreTranslate: supports a public or self-hosted endpoint. API key is optional when the chosen server does not require one.
- DeepL API: defaults to the API Free endpoint and supports changing the endpoint for a Pro account.
- Ollama: uses a locally hosted model through /api/generate.
- OpenAI: remains available as an optional provider.

Field-level cache
-----------------
Each Norwegian field has its own SHA-256 source hash. Only a new or changed field is translated. Existing English translations are reused for all unchanged fields.

Configuration
-------------
Open CV -> CV settings -> English translation.
1. Enable automatic translation.
2. Select a provider.
3. Enter the endpoint, model and/or API key required by that provider.
4. Save.
5. Open the English CV once to generate missing or changed translations.

Use "Translate all fields again" to clear only the source hashes. Existing English content remains visible until refreshed.

Ollama note
-----------
The Ollama endpoint must be reachable from the WordPress server. 127.0.0.1 refers to the web server itself, not the visitor's computer.

import { ApifyClient } from 'apify-client';

const client = new ApifyClient({ token: 'apify_api_5Bz3X77frYBWORCfDD1Xj2ghw8WpGW2tdhgs' });

// Starts an Actor and waits for it to finish
const { defaultDatasetId } = await client.actor('username/actor-name').call();

// Lists items from the Actor's dataset
const { items } = await client.dataset(defaultDatasetId).listItems();

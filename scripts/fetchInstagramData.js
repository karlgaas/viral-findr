// scripts/fetchInstagramData.js
import { ApifyClient } from 'apify-client';
import dotenv from 'dotenv';

dotenv.config(); // Load environment variables

async function fetchInstagramData(username) {
    const client = new ApifyClient({ token: 'apify_api_5Bz3X77frYBWORCfDD1Xj2ghw8WpGW2tdhgs' });
    const input = {
        "directUrls": [`https://www.instagram.com/${username}/`],
        "resultsLimit": 1,
        "type": ['Video'],
        // 'timeoutSecs': 50,
        // "searchLimit": 1,
        // "addParentData": false
    };

    const run = await client.actor("apify/instagram-scraper").call(input);
    const { items } = await client.dataset(run.defaultDatasetId).listItems();
    return items;
}

(async () => {
    const username = process.argv[2];
    if (!username) {
        console.error('Please provide an Instagram username');
        process.exit(1);
    }

    try {
        const results = await fetchInstagramData(username);
        console.log(JSON.stringify(results));
    } catch (error) {
        console.error(error);
        process.exit(1);
    }
})();

import express from 'express';
import { ApifyClient } from 'apify-client';
import dotenv from 'dotenv';

dotenv.config(); // Load environment variables

const app = express();
const port = 3000; // You can change this port number if needed

app.use(express.json());

// const client = new ApifyClient({ token: process.env.APIFY_API_TOKEN });
const client = new ApifyClient({ token: 'apify_api_itb9SRus81ofAen1bIQ5JR9yfIgBtC1buE35' });

async function fetchInstagramData(username) {
    const input = {
        "directUrls": [`https://www.instagram.com/${username}/`],
        "resultsLimit": 5,
    };

    const run = await client.actor("apify/instagram-scraper").call(input);
    const { items } = await client.dataset(run.defaultDatasetId).listItems();
    return items;
}

app.get('/fetchInstagramData', async (req, res) => {
    const username = req.query.username;

    if (!username) {
        return res.status(400).json({ error: 'Please provide an Instagram username' });
    }

    try {

        const results = await fetchInstagramData(username);
        res.json(results);
        
        // res.json(["test"]);

    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}/`);
});
const fetch = require('node-fetch');

async function testHeaders() {
    const res = await fetch("http://127.0.0.1:8000/login");
    console.log("Status:", res.status);
    console.log("Headers:");
    for (const [key, value] of res.headers) {
        console.log(`  ${key}: ${value}`);
    }
}

testHeaders();

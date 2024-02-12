function getJSONDiff(json1, json2) {
    const obj1 = JSON.parse(json1);
    const obj2 = JSON.parse(json2);

    // Find keys where the values are different
    const differentKeys = [];
    for (const key in obj1) {
        if (obj1[key] !== obj2[key]) {
            differentKeys.push(key);
        }
    }

    // Return the sorted keys where the values are different
    return differentKeys.sort();
}

// Example usage
const json1 = '{"hacker": "rank", "input": "output"}';
const json2 = '{"hacker": "ranked", "input": "wrong"}';

const result = getJSONDiff(json1, json2);
console.log(result);

/* Expected result:

hacker
input

*/

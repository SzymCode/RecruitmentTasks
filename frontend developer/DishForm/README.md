# DishForm  <div> ![Typescript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white&style=plastic) ![React](https://img.shields.io/badge/React-%2320232a.svg?style=for-the-badge&logo=react&logoColor=%2361DAFB&style=plastic) ![HTML5](https://img.shields.io/badge/HTML5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white&style=plastic) ![CSS3](https://img.shields.io/badge/CSS3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white&style=plastic) ![MUI](https://img.shields.io/badge/Material%20UI-%230081CB.svg?style=for-the-badge&logo=mui&logoColor=white&style=plastic) ![Bootstrap](https://img.shields.io/badge/Bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white&style=plastic) </div>

This is a recruitment exercise project for [HexOcean](https://hexocean.com/) company.
The Dish Form allows users to create and submit information about various dishes, including their names, preparation time, types, and additional details specific to each type of dish. </br>
[Preview!](https://dishform.herokuapp.com/)

<details><summary> <h2>  📖 Problem description  </summary>

```
Create a form that will contain the following fields:
name - dish name (text field)
preparation_time - preparation time (duration field, would be nice if the input will be formatted like 00:00:00)
type - dish type (select field with the following options: pizza, soup, sandwich)

After selecting dish type, conditionally display other fields:
for pizza:
 • no_of_slices - # of slices (number field)
 • diameter - diameter (float field)

for soup:
 • spiciness_scale - spiciness scale (1-10)

for sandwich:
 • slices_of_bread - number of slices of bread required (number field)

All fields should be required (fields depending on the dish type should be required conditionally based on what type of dish is selected).

Data should be submitted via POST request as a JSON to https://umzzcc503l.execute-api.us-west-2.amazonaws.com/dishes/ and the form should support returned validation errors (if any).

Example request:
curl -H 'Content-Type: application/json' -X POST -d '{"name": "Test pizza", "preparation_time": "01:30:22", "type": "pizza", "no_of_slices": 4, "diameter": 33.4}' https://umzzcc503l.execute-api.us-west-2.amazonaws.com/dishes/

Example response:
{
  "diameter": 33.4,
  "name": "Test pizza",
  "no_of_slices": 4,
  "preparation_time": "01:30:22",
  "type": "pizza",
  "id": 1
}
```

</details>


<details><summary> <h2>  🛠️ Installation  </summary>

• First make sure u have installed latest versions of [ReactJS, NodeJS,](https://www.tutorialspoint.com/reactjs/reactjs_environment_setup.htm)

• Clone this repository.

• Install modules using npm install in **dish-form** directory.

```bash
npm install
```

### **Make sure u have installed all modules!**

</details>


<details><summary> <h2>  🚀 Run  </summary>

• **dish-form** directory:

```bash
npm start
```

</details>  


<details><summary> <h2> ❓ Usage  </summary>

• **localhost:3000** - Dish Form page

</details>  



<details><summary> <h2> ✅ Solved Problems  </summary>

- [X] Completed dish form with variations

- [X] Modern form library - Formik

- [X] Validation handling

- [X] Material UI

- [X] TypeScript

- [X] Live preview

</details>


<div align="center">
  
![React](https://img.shields.io/badge/react-%2320232a.svg?style=for-the-badge&logo=react&logoColor=%2361DAFB)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white)\
<img src="https://img.shields.io/badge/node-18.15.0-blue"/>
<img src="https://img.shields.io/badge/npm-9.6.5-brightgreen"/>
</div>

# DishFormReact
This is a recruitment exercise project that focuses on building a Dish Form application. 
The Dish Form allows users to create and submit information about various dishes, including their names, preparation time, types, and additional details specific to each type of dish.

<details><summary> <h2>  📖 Problem description  </summary>
<b> Create a form that will contain the following fields: </b> </br>
name - dish name (text field) </br>
preparation_time - preparation time (duration field, would be nice if the input will be formatted like 00:00:00) </br>
type - dish type (select field with the following options: pizza, soup, sandwich) </br> </br> 

<b>  After selecting dish type, conditionally display other fields: </b> </br> 
<i> for pizza: </i> </br>
 • no_of_slices - # of slices (number field) </br>
 • diameter - diameter (float field) </br>

<i> for soup: </i> </br>
 • spiciness_scale - spiciness scale (1-10) </br>

<i> for sandwich: </i> </br>
 • slices_of_bread - number of slices of bread required (number field) </br> </br>

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


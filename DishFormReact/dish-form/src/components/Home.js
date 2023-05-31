import React from 'react';
import { useFormik } from 'formik';


const Home = () => {
  const formik = useFormik({
    initialValues: {
      dishName: '',
      preparationTime: '',
      dishType: '',
      noOfSlices: '',
      diameter: '',
      spicinessScale: '',
      slicesOfBread: '',
    },
    onSubmit: (values) => {
      const dish = {
        name: values.dishName,
        preparation_time: values.preparationTime,
        type: values.dishType,
        no_of_slices: values.dishType === 'pizza' ? parseInt(values.noOfSlices) : undefined,
        diameter: values.dishType === 'pizza' ? parseFloat(values.diameter) : undefined,
        spiciness_scale: values.dishType === 'soup' ? parseInt(values.spicinessScale) : undefined,
        slices_of_bread: values.dishType === 'sandwich' ? parseInt(values.slicesOfBread) : undefined,
      };

      fetch('https://umzzcc503l.execute-api.us-west-2.amazonaws.com/dishes/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(dish),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data); // Show the response data
        })
        .catch((error) => {
          console.error(error); // Handle errors
        });
    },
  });

  return (
    <div id="container-fluid">
      <h1 id="header">
        Create a Dish
      </h1>
      <form onSubmit={formik.handleSubmit}>

        <div>
          <label htmlFor="dishName">
            Dish Name:
          </label>
          <input type="text" id="dishName" name="dishName" value={formik.values.dishName} onChange={formik.handleChange} required/>
        </div>

        <div>
          <label htmlFor="preparationTime">
            Preparation Time (HH:MM:SS):
          </label>
          <input type="text" id="preparationTime" name="preparationTime" value={formik.values.preparationTime} onChange={formik.handleChange} required/>
        </div>

        <div>
          <label htmlFor="dishType">
            Dish Type:
          </label>
          <select id="dishType" name="dishType" value={formik.values.dishType} onChange={formik.handleChange} required>
            <option value="">
              Select Type
            </option>
            <option value="pizza">
              Pizza
            </option>
            <option value="soup">
              Soup
            </option>
            <option value="sandwich">
              Sandwich
            </option>
          </select>
        </div>

        {formik.values.dishType === 'pizza' && (
          <div>
            <label htmlFor="noOfSlices">
              Number of Slices:
            </label>
            <input type="number" id="noOfSlices" name="noOfSlices" value={formik.values.noOfSlices} onChange={formik.handleChange} required/>
          </div>
        )}
        {formik.values.dishType === 'pizza' && (
          <div>
            <label htmlFor="diameter">
              Diameter:
            </label>
            <input type="number" step="0.1" id="diameter" name="diameter" value={formik.values.diameter} onChange={formik.handleChange} required/>
          </div>
        )}
        {formik.values.dishType === 'soup' && (
          <div>
            <label htmlFor="spicinessScale">
              Spiciness Scale (1-10):
            </label>
            <input type="number" id="spicinessScale" name="spicinessScale" value={formik.values.spicinessScale} onChange={formik.handleChange} min="1" max="10" required/>
          </div>
        )}
        {formik.values.dishType === 'sandwich' && (
          <div>
            <label htmlFor="slicesOfBread">
              Slices of Bread:
            </label>
            <input type="number" id="slicesOfBread" name="slicesOfBread" value={formik.values.slicesOfBread} onChange={formik.handleChange} required/>
          </div>
        )}

        <button>Submit</button>

      </form>
    </div>
  );
};

export default Home;
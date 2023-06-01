import * as React from 'react';
import { useFormik } from 'formik';
import { Button, Slider, Select, MenuItem } from '@mui/material';



interface FormValues {
  dishName: string;
  preparationTime: string;
  dishType: string;
  noOfSlices: string;
  diameter: string;
  spicinessScale: string;
  slicesOfBread: string;
}

const Home: React.FC = () => {
  const formik = useFormik<FormValues>({
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
            console.log(data);
          })
          .catch((error) => {
            console.error(error);
          });
    },
  });


  return (
      <div id="container-fluid">
        <h1 className="header">Create a Dish</h1>
        <form onSubmit={formik.handleSubmit}>
          <div>
            <label htmlFor="dishName" className="dishNameLabel">
              Dish Name:
            </label>
            <input type="text" name="dishName" id="dishName" className="form-control dishName" value={formik.values.dishName} onChange={formik.handleChange} required/>
          </div>

          <div>
            <label htmlFor="preparationTime" className="preparationTimeLabel">
              Preparation Time (HH:MM:SS):
            </label>
            <input type="text" name="preparationTime" id="preparationTime" className="form-control preparationTime" value={formik.values.preparationTime} onChange={formik.handleChange} required/>
          </div>

          <div>
            <label className="dishTypeLabel">
              Dish Type:
            </label>

            <Select id="dishType" name="dishType" className="form-control dishType" value={formik.values.dishType} onChange={formik.handleChange} required>
              <MenuItem value="Select Type">Select Type</MenuItem>
              <MenuItem value="pizza">Pizza</MenuItem>
              <MenuItem value="soup">Soup</MenuItem>
              <MenuItem value="sandwich">Sandwich</MenuItem>
            </Select>
          </div>

          {formik.values.dishType === 'pizza' && (
              <div>
                <label className="noOfSlicesLabel">
                  Number of Slices:
                </label>
                <Slider name="noOfSlices" id="noOfSlices" className="form-control noOfSlices" value={Number(formik.values.noOfSlices)} onChange={formik.handleChange}
                    marks step={1} min={1} max={8} defaultValue={1} valueLabelDisplay="auto"/>
              </div>
          )}

          {formik.values.dishType === 'pizza' && (
              <div>
                <label htmlFor="diameter" className="diameterLabel">
                  Diameter:
                </label>
                <input type="number" name="diameter" id="diameter" className="form-control diameter" value={formik.values.diameter} onChange={formik.handleChange} required
                    step={0.1} min={0}/>
              </div>
          )}

          {formik.values.dishType === 'soup' && (
              <div>
                <label className="spicinessScaleLabel">
                  Spiciness Scale (1-10):
                </label>
                <Slider name="spicinessScale" id="spicinessScale" className="form-control spicinessScale" value={Number(formik.values.spicinessScale)} onChange={formik.handleChange}
                    marks step={1} min={1} max={10} defaultValue={1} valueLabelDisplay="auto"/>
              </div>
          )}

          {formik.values.dishType === 'sandwich' && (
              <div>
                <label htmlFor="slicesOfBread" className="slicesOfBreadLabel">
                  Slices of Bread:
                </label>
                <input type="number" name="slicesOfBread" id="slicesOfBread" className="form-control slicesOfBread" value={formik.values.slicesOfBread} onChange={formik.handleChange} required
                    step={1} min={1}/>
              </div>
          )}

          <Button variant="contained" className="submitButton" type="submit">
            Submit
          </Button>
        </form>
      </div>
  );
};

export default Home;

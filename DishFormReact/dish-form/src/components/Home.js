import React, { Component } from 'react';
class Home extends Component {
  constructor(props) {
    super(props);

    this.state = {
      dishName: '',
      preparationTime: '',
      dishType: '',
      noOfSlices: '',
      diameter: '',
      spicinessScale: '',
      slicesOfBread: '',
    };
  }

  handleFormSubmit = (event) => {
    event.preventDefault();

    const {
      dishName,
      preparationTime,
      dishType,
      noOfSlices,
      diameter,
      spicinessScale,
      slicesOfBread,
    } = this.state;

    const dish = {
      name: dishName,
      preparation_time: preparationTime,
      type: dishType,
      no_of_slices: dishType === 'pizza' ? parseInt(noOfSlices) : undefined,
      diameter: dishType === 'pizza' ? parseFloat(diameter) : undefined,
      spiciness_scale: dishType === 'soup' ? parseInt(spicinessScale) : undefined,
      slices_of_bread: dishType === 'sandwich' ? parseInt(slicesOfBread) : undefined,
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
  };

  handleInputChange = (event) => {
    const { name, value } = event.target;
    this.setState({ [name]: value });
  };

  render() {
    return (
        <div id="container-fluid">
          <h1 id="header">Create a Dish</h1>
          <form onSubmit={this.handleFormSubmit}>

            <div>
              <label htmlFor="dishName">
                Dish Name:
              </label>
              <input type="text" id="dishName" name="dishName" value={this.state.dishName} onChange={this.handleInputChange} required/>
            </div>

            <div>
              <label htmlFor="preparationTime">
                Preparation Time (HH:MM:SS):
              </label>
              <input type="text" id="preparationTime" name="preparationTime" value={this.state.preparationTime} onChange={this.handleInputChange} required/>
            </div>

            <div>
              <label htmlFor="dishType">
                Dish Type:
              </label>
              <select id="dishType" name="dishType" value={this.state.dishType} onChange={this.handleInputChange} required>
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

            {this.state.dishType === 'pizza' && (
                <div>
                  <label htmlFor="noOfSlices">
                    Number of Slices:
                  </label>
                  <input type="number" id="noOfSlices" name="noOfSlices" value={this.state.noOfSlices} onChange={this.handleInputChange} required/>
                </div>
            )}
            {this.state.dishType === 'pizza' && (
                <div>
                  <label htmlFor="diameter">
                    Diameter:
                  </label>
                  <input type="number" step="0.1" id="diameter" name="diameter" value={this.state.diameter} onChange={this.handleInputChange} required/>
                </div>
            )}
            {this.state.dishType === 'soup' && (
                <div>
                  <label htmlFor="spicinessScale">
                    Spiciness Scale (1-10):
                  </label>
                  <input type="number" id="spicinessScale" name="spicinessScale" value={this.state.spicinessScale} onChange={this.handleInputChange} min="1" max="10" required/>
                </div>
            )}
            {this.state.dishType === 'sandwich' && (
                <div>
                  <label htmlFor="slicesOfBread">
                    Slices of Bread:
                  </label>
                  <input type="number" id="slicesOfBread" name="slicesOfBread" value={this.state.slicesOfBread} onChange={this.handleInputChange} required/>
                </div>
            )}

            <button>Submit</button>
          </form>
        </div>
    );
  }
}
export default Home;
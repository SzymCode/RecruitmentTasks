import * as React from 'react';
import './styles/bootstrap.min.css';
import './styles/App.css';
import Home from './components/Home';
import { Routes, Route } from 'react-router-dom';

const App: React.FC = () => {
  return (
    <div className="container-fluid">
      <Routes>
        <Route path="*" element={<Home />} />
      </Routes>
    </div>
  );
};

export default App;
// import logo from './logo.svg';
 import './App.css';
import * as React from 'react'
import "bootstrap/dist/css/bootstrap.css"
import {BrowserRouter as Router ,Routes,Route,Link} from 'react-router-dom'
import EditProduct from './components/Edit.product'
import CreateProduct from './components/Create.product'
import ProductList from './components/List.product' 
function App() {
  return (
   <Router>
    <nav className="navbar navbar-expand-lg  navbar-dark bg-dark sticky-top">
        <div className="container-fluid">
        
          <Link to={"/"} className="navbar-brand">Rsell</Link>

          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0">
             
              <li className="nav-item">
                <Link className="nav-link" to={"/product/create"}>Create</Link>
              </li>  
              <li className="nav-item"><Link to={"/"} className="nav-link">Products</Link></li>

            </ul> 
          </div>
        </div>
      </nav>

    <Routes>
<Route path="/product/create" element={<CreateProduct/>}> </Route>
<Route path="/product/EditProduct/:id" element={<EditProduct/>}></Route>
<Route path="/" element={<ProductList/>}></Route>

     </Routes>
   </Router>
   
  );
}

export default App;

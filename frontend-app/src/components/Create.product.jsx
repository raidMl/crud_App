import React,{useState} from "react";
import axios from "axios"
import {useNavigate} from 'react-router-dom';
export default function CreateProduct(){

    const navigate=useNavigate();

    const [title,setTitle]=useState('');
    const [description,setDescription]=useState('');
    const [image,setImage]=useState('');

    const changeHandler=(e)=>{
        setImage(e.target.files[0])
    }
    
    const createProduct=async(e)=>{ //async to garantiate data  sent to server larvel we use  async and wait 
        
        e.preventDefault();  
       const formData=new FormData(); //we create a class and send it to  # L_a_r_a_v_e_l #
       formData.append('title',title); //'' in table laravel  // norml in form
       formData.append('description',description);
       formData.append('image',image);
       
      

       console.log(formData);
       await axios.post('http://127.0.0.1:8000/api/products', formData)
       .then(({data})=>{
           console.log(data.message)
           navigate('/')
       }).catch(({response})=>{
           if (response.status ==422) {
               console.log(response.data.errors)
           } else {
               console.log(response.data.message)
           }
       })
   }

  //form in html 
  return(
    <div className="container">
        <div className="row justify-content-center">
            <div className="col-12 col-sm-12 col-md-12">
                <div className="card">
                    <div className="card-body">
                        <h3 className="card-title">Create Form </h3>
                        <hr></hr>
                        <div className="form-wrapper">
<form onSubmit={createProduct}>
<div className="mb-3">
  <label for="exampleFormControlInput1" className="form-label">Title</label>
  <input type="text" className="form-control" id="exampleFormControlInput1" placeholder="Enter the product name"
  value={title}
  onChange={(e)=>{setTitle(e.target.value)}}
  />
</div>
<div className="mb-3">
  <label for="exampleFormControlTextarea1" className="form-label">Description</label>
  <textarea className="form-control" id="exampleFormControlTextarea1" rows="3"
  value={description}
  onChange={(e)=>(setDescription(e.target.value))}
  ></textarea>
</div>

<div className="mb-3">
  <label for="exampleFormControlInput3" className="form-label">Image</label>
  
  <input type="file" className="form-control" id="exampleFormControlInput3" 
  
  onChange={changeHandler}
  />
 
</div>
                                     

<div className="col-auto">
    <button type="submit"  class="btn btn-primary mb-3">Save</button>
  </div>

</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  )  
}
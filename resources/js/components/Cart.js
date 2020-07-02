import React, { Component } from 'react';
import ReactDom from 'react-dom';
import Axios from 'axios';
import Swal from 'sweetalert2';
import {sum, get} from 'lodash';

class Cart extends Component {


        constructor(props) {
            super(props)
            this.state = {
                cart : [],
                products : [],
                customers : [],
                discounts : [],
            };

            this.loadCart = this.loadCart.bind(this);
            this.loadProduct = this.loadProduct.bind(this);
            this.loadCustomer = this.loadCustomer.bind(this);
            this.loadDiscount = this.loadDiscount.bind(this);
            this.handleClickDelete = this.handleClickDelete.bind(this);
            this.setCustomerId = this.setCustomerId.bind(this);
            this.handleDiscountAmount = this.handleDiscountAmount.bind(this);
            this.getTotal = this.getTotal.bind(this);
            this.handleChangeQty = this.handleChangeQty.bind(this);
            this.handleEmptyCart = this.handleEmptyCart.bind(this);
            this.handleClickSubmit = this.handleClickSubmit.bind(this);
        }


        componentDidMount(){
            this.loadCart();
            this.loadProduct();
            this.loadDiscount();
            this.loadCustomer();
        }

        componentDidUpdate(prevProps, prevState) {
            this._input.focus();
        }

        loadCart(){
            Axios.get('/cart').then(res => {
                const cart = res.data;
                this.setState({cart});
            });
        }

        loadProduct(){
            Axios.get('/products').then(res => {
                const products = res.data.data;
                this.setState({products});
            });
        }

        loadCustomer(){
            Axios.get('/customers').then(res => {
                const customers = res.data;
                this.setState({customers});
            });
        }

        loadDiscount(){
            Axios.get('/discount-cart').then(res => {
                const discounts = res.data;
                this.setState({discounts});
            })
        }

        handleClickDelete(product_id){
            Axios.post('cart/delete',{product_id, _method: 'DELETE'}).then(res => {
                const cart = this.state.cart.filter(c => c.id !== product_id);
                this.setState({cart});
            })
        }

        addItemToCart(drug_name)
        {   
            console.log(drug_name);
            Axios.post('/cart', {drug_name}).then(res => {
                this.loadCart();
            }).catch(err => {
                Swal.fire(
                    'Error',
                    err.response.data.message,
                    'error'
                )
            });
        }

        setCustomerId(event)
        {   
            const data = event.target.value;
            if(data == undefined){
                this.setState({customer_id : "0"})
            }else{
                this.setState({customer_id : data})
            }
        }

        handleDiscountAmount(cart)
        {     
            //   const discount = event.target.value / 100;
            //   const data = this.state.cart.map(c => {
            //       const data = c.selling_price;
            //       c.selling_price = data - (data * discount);
            //       return c;
            //   });
            //   this.setState({data})
            //   if(discount == "0"){
            //     Axios.get('/cart').then(res => {
            //         const cart = res.data;
            //         this.setState({cart});
            //     });
            //   }
            const discount = event.target.value / 100;
            this.setState({discount : discount});
        }

        getTotal(cart)
        {   
            const discount = this.state.discount;
            const data = cart.map(c=> c.pivot.quantity * c.selling_price);
            if(discount == undefined){
                const total = sum(data);
                return total;
            }else{
                const pp = sum(data);
                const total = pp - (pp * discount);
                return total;
            }
            
        }

        handleChangeQty(product_id, qty)
        {
            const cart = this.state.cart.map(c => {
                if(c.id == product_id) {
                    c.pivot.quantity = qty;
                }
                return c;
            });
            this.setState({cart})
            Axios.post('/cart/change-qty', {product_id, quantity: qty}).then(res => {

            }).catch(err => {
                Swal.fire(
                    'Error!',
                    err.response.data.message,
                    'error'
                )
            });
        }

        handleEmptyCart(){
            Axios.post('/cart/empty', {_method: 'DELETE'}).then(res => {
                this.setState({cart: []});
                this.discountListObject.value = "0";
            })
        }

        handleClickSubmit(){
            Swal.fire({
                title : 'Recieved Amount',
                input : 'text',
                inputValue : this.getTotal(this.state.cart),
                showCancelButton : true,
                confirmButtonText : 'Check Out',
                showLoaderOnConfirm : true,
                preConfirm : (amount) => {
                    return Axios.post('/cart/checkout', {customer_id : this.state.customer_id, 
                    discount : this.state.discount, amount}).then(res => {
                        this.loadCart();
                        this.loadProduct();
                        return res.data;
                    }).catch(err => {
                        Swal.showValidationMessage(err.response.data.message)
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if(result.value) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer:2000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                      })

                      Toast.fire({
                        icon: 'success',
                        title: 'SUCCESS!'
                      })
                }
            })
        }


    render() {
        const {cart, products, customers, discounts, discount, customer_id} = this.state;
        return (
            <div className="container">
            <div className="row">
                <div className="col-lg-7">
                    <div className="card" id="item-cart">
                        <div className="card-body">
                            <table className="table table-bordered text-center">
                                <thead className="bg-success">
                                    <tr>
                                        <th>DRUG NAME</th>
                                        <th>CHEMICAL NAME</th>
                                        <th>QTY</th>
                                        <th>PRICE</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   {products.map(p => ( 
                                    <tr key={p.id}>
                                        <td>{p.drug_name}</td>
                                        <td>{p.chemical_name}</td>
                                        <td>{p.quantity}</td>
                                        <td>{p.selling_price} Ks</td>
                                        <td><button 
                                        className="btn btn-success btn-sm"
                                        onClick={() => this.addItemToCart(p.drug_name)}
                                        >ADD</button></td>
                                    </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div className="col-lg-5">
                    <div className="row disc-card">
                        <div className="col">
                        <form>
                            <input type="text" 
                            className="form-control" 
                            placeholder="SCAN BARCODE"
                            autoFocus
                            ref = {b => (this._input = b)}
                            />
                        </form>
                        </div>
                        <div className="col-md-7">
                            <select name="" id="" 
                            className="form-control"
                            onChange={this.setCustomerId}
                            >
                                <option value="0">WALK IN CUSTOMER</option>
                            {customers.map(cus => (
                                <option key ={cus.id} value ={cus.id}>{cus.name}</option>
                            ))}
                            </select>
                        </div>
                    </div>
                    <div className="card mt-1">
                        <div className="card-body" id="user-cart">
                            <table className="table table-bordered text-center disc-card">
                                <thead className="bg-success">
                                    <tr>
                                        <th>DRUG NAME</th>
                                        <th>QTY</th>
                                        <th>PRICE</th>
                                        <th><i className="fas fa-trash tr-can"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {cart.map(c => (
                                        <tr key={c.id}>
                                        <td>{c.drug_name}</td>
                                        <td>
                                        <input 
                                        type="text" 
                                        className="form-control form-control-sm qty" 
                                        value={c.pivot.quantity}
                                        onChange={event => this.handleChangeQty(c.id, event.target.value)}
                                        />
                                        </td>
                                        <td>{c.selling_price * c.pivot.quantity} Ks</td>
                                        <td className="trash"><button 
                                        className="btn btn-sm btn-danger mt-2"
                                        onClick = {() => this.handleClickDelete(c.id)}
                                        ><i className="fa fa-minus"></i></button></td>
                                    </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div className="card disc-card">
                        <div className="card-body">
                               <div className = "row text-center">
                                <div className="col mt-2">
                                    SELECT DISCOUNT
                                </div>
                               <div className="col">
                               
                               <select className="form-control" 
                                        onChange={event=> this.handleDiscountAmount(cart)}
                                        
                                        disabled = {! cart.length}
                                        ref={(scope) => {this.discountListObject= scope;}} >
                                            <option value="0">NO DISCOUNT</option>
                                            {discounts.map(dis => (
                                            <option key={dis.id} value ={dis.amount}>{dis.discount_name}&nbsp;&nbsp;/&nbsp;&nbsp;{dis.amount}%</option>
                                         
                                        ))}
                                        </select>   
                               </div>
                               </div>
                        </div>
                    </div>
                    <div className="card disc-card">
                        <div className="card-body">
                            <table className="table table-bordered text-center disc-card">
                                <thead>
                                <tr>
                                    <th className="bg-success vertical">TOTAL</th>
                                    <td>{this.getTotal(cart).toFixed(0)} Ks</td>
                                </tr>
                                </thead>
                            </table>
                            <table className="table table-bordered text-center mt-2">
                               <thead>
                               <tr>
                                    <td><button 
                                    className="btn btn-danger"
                                    onClick = {this.handleEmptyCart}
                                    disabled = {! cart.length}
                                    >&nbsp;&nbsp;&nbsp;CANCEL&nbsp;&nbsp;</button></td>
                                    <td><button 
                                    className="btn btn-success"
                                    onClick = {this.handleClickSubmit}
                                    >CHECK OUT</button></td>
                                </tr>
                               </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        );
    }
}

export default Cart;

if(document.getElementById('cart'))
{
    ReactDom.render(<Cart />, document.getElementById('cart'));
}
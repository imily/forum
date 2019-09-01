import React, {Component} from 'react';
import Menu from './Common/Menu';
import Banner from './Common/Banner';
import Footer from './Common/Footer';

class MasterNoLogin extends Component{
    render() {
        return (
            <div className="wrap">
                <div className="header">
                    <Menu />
                    <Banner />
                </div>
                <Footer />
            </div>
        );
    }
}

export default MasterNoLogin;

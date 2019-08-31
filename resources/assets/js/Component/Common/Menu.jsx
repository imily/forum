import React, {Component} from 'react';

class Menu extends Component{
    render () {
        return (
            <div className="menu">
                <div className="container">
                    <a href="#" className="logo">Person Of Interest</a>
                    <div className="open-btn"> </div>
                    <a className="member-user" href="#">
                        Welcome <span>Imily</span>
                        <i> </i>
                    </a>
                    <ul className="list-h site-nav" itemScope itemType="http://schema.org/SiteNavigationElement">
                        <li><a href="#">Production</a></li>
                        <li><a href="#">Forum</a></li>
                        <li><a href="#">Member</a></li>
                    </ul>
                </div>
            </div>
        );
    }
}

export default Menu;

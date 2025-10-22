import SideMenu from "../components/Sidemenu";
import styles from "../styles/pages/dashboard.module.scss";
import { useState } from "react";
import RegisterUser from "../components/RegisterUser";
import CategoryForm from "../components/CategoryForm";
import ProductForm from "../components/ProductForm";
import SalesInvoicing from "../components/SalesInvoicing";
import PurchaseForm from "../components/PurchaseForm";

function Dashboard() {
  const [selectedMenu, setSelectedMenu] = useState(null);

  return (
    <div className={styles.dashboard}>
      <SideMenu selected={selectedMenu} onSelect={setSelectedMenu} />
      <div className={styles.content}>
        {selectedMenu === "Users" && <RegisterUser />}
        {selectedMenu === "Categories" && <CategoryForm />}
        {selectedMenu === "Products" && <ProductForm />}
        {selectedMenu === "Invoicing" && <SalesInvoicing />}
        {selectedMenu === "Purchases" && <PurchaseForm />}
      </div>
    </div>
  );
}

export default Dashboard;

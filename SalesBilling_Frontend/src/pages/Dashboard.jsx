import SideMenu from "../components/Sidemenu";
import styles from "../styles/pages/dashboard.module.scss";
import { useState } from "react";
import RegisterUser from "../components/RegisterUser";
import CategoryForm from "../components/CategoryForm";
import ProductForm from "../components/ProductForm";
function Dashboard() {
  const [selectedMenu, setSelectedMenu] = useState(null);

  return (
    <div className={styles.dashboard}>
      <SideMenu selected={selectedMenu} onSelect={setSelectedMenu} />
      <div className={styles.content}>
        {selectedMenu === "Users" && <RegisterUser />}
        {selectedMenu === "Categories" && <CategoryForm />}
        {selectedMenu === "Products" && <ProductForm />}
      </div>
    </div>
  );
}

export default Dashboard;

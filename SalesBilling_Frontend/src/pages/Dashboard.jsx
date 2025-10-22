import SideMenu from "../components/Sidemenu";
import styles from "../styles/pages/dashboard.module.scss";
import { useState } from "react";
import RegisterUser from "../components/RegisterUser";

function Dashboard() {
  const [selectedMenu, setSelectedMenu] = useState(null);

  return (
    <div className={styles.dashboard}>
      <SideMenu selected={selectedMenu} onSelect={setSelectedMenu} />
      <div className={styles.content}>
        {selectedMenu === "Users" && <RegisterUser />}
      </div>
    </div>
  );
}

export default Dashboard;

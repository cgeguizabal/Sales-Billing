import styles from "../styles/components/sideMenu.module.scss";
import useAuthStore from "../store/auth";

function SideMenu({ selected, onSelect }) {
  const logout = useAuthStore((state) => state.logout);
  const { user } = useAuthStore(); // get current user

  const menuItems = [
    "Users",
    "Sales",
    "Suppliers",
    "Categories",
    "Products",
    "Invoicing",
    "Purchases",
    "Reports",
    "Banks",
  ];

  // define which menu each role can see
  const roleMenuMap = {
    Admin: menuItems, // everything
    Cashier: ["Sales", "Invoicing"],
    RH: ["Users"],
    Counter: menuItems.filter((item) => item !== "Users"), // everything except Users
  };

  // get allowed menu for current role
  const allowedMenu = roleMenuMap[user?.roles[0]] || [];

  return (
    <nav className={styles.sideMenu}>
      {allowedMenu.map((item) => (
        <button
          key={item}
          className={`${styles.menuItem} ${
            selected === item ? styles.active : ""
          }`}
          onClick={() => onSelect(item)}
        >
          {item}
        </button>
      ))}

      <button
        className={`${styles.menuItem} ${styles.logoutButton}`}
        onClick={logout}
      >
        Logout
      </button>
    </nav>
  );
}

export default SideMenu;

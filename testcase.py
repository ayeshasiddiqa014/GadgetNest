from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import unittest


class WebAppTests(unittest.TestCase):
    BASE_URL = "http://localhost/Web%20App"
    LOGIN_URL = "/login.php"
    DASHBOARD_URL = "/dashboard.php"
    CART_URL = "/cart.php"

    @classmethod
    def setUpClass(cls):
        # Set up Chrome options for headless mode
        chrome_options = Options()
        chrome_options.add_argument("--headless")
        
        chrome_driver_path = "C:\\chromedriver\\chromedriver-win32\\chromedriver.exe"
        cls.driver = webdriver.Chrome(service=Service(chrome_driver_path), options=chrome_options)

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()

    def wait_for_element(self, by, value):
        return WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((by, value)))
    
    def wait_for_element_to_be_clickable(self, by, value):
        return WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((by, value)))

    def test_login_with_valid_credentials(self):
        self.driver.get(self.BASE_URL + self.LOGIN_URL)
        username_input = self.wait_for_element(By.NAME, "username")
        password_input = self.wait_for_element(By.NAME, "password")
        submit_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "input[type='submit']")

        username_input.send_keys("admin")
        password_input.send_keys("admin")
        submit_button.click()

        self.assertEqual(self.driver.current_url, self.BASE_URL + self.DASHBOARD_URL)

    def test_login_with_invalid_credentials(self):
        self.driver.get(self.BASE_URL + self.LOGIN_URL)
        username_input = self.wait_for_element(By.NAME, "username")
        password_input = self.wait_for_element(By.NAME, "password")
        submit_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "input[type='submit']")

        username_input.send_keys("invalid_username")
        password_input.send_keys("invalid_password")
        submit_button.click()

        error_message = self.wait_for_element(By.CSS_SELECTOR, "p[style='color: red;']").text
        self.assertEqual(error_message, "Invalid username or password. Please try again.")

    def test_empty_login_fields(self):
        self.driver.get(self.BASE_URL + self.LOGIN_URL)
        submit_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "input[type='submit']")
        submit_button.click()

        username_input = self.wait_for_element(By.NAME, "username")
        password_input = self.wait_for_element(By.NAME, "password")

        self.assertTrue(username_input.get_attribute("required"))
        self.assertTrue(password_input.get_attribute("required"))

    def test_add_product_to_cart_successfully(self):
        self.driver.get(self.BASE_URL + self.DASHBOARD_URL)
        product_name_input = self.wait_for_element(By.NAME, "product_name")
        quantity_input = self.wait_for_element(By.NAME, "quantity")
        add_to_cart_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "input[id='addToCart']")

        product_name_input.send_keys("LAPTOP")
        quantity_input.send_keys("2")
        add_to_cart_button.click()

        success_message = self.wait_for_element(By.CSS_SELECTOR, "p[style='color:lightgreen']").text
        self.assertEqual(success_message, "Product added to your order.")

    def test_remove_product_from_cart_successfully(self):
        self.driver.get(self.BASE_URL + self.DASHBOARD_URL)
        remove_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "input[value='Remove']")
        remove_button.click()

        success_message = self.wait_for_element(By.CSS_SELECTOR, "p[style='color: lightcoral;']").text
        self.assertEqual(success_message, "Product removed from your order.")

    def test_logout(self):
        self.driver.get(self.BASE_URL + self.DASHBOARD_URL)
        logout_button = self.wait_for_element_to_be_clickable(By.CSS_SELECTOR, "a[id='logout']")
        logout_button.click()
        self.assertEqual(self.driver.current_url, self.BASE_URL + self.LOGIN_URL)

if __name__ == "__main__":
    unittest.main()

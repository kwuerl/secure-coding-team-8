/**
 * Main class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */

package securebank.scs.ui.application;

import java.awt.EventQueue;

public class Main {
	/**
	 * Launch the application.
	 */
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			@Override
			public void run() {
				try {
					SmartCardSimulator window = new SmartCardSimulator();
					window.frmSecureBank.setVisible(true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}
}
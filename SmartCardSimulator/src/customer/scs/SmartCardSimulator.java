/**
 * SmartCardSimulator class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */

package customer.scs;

import java.awt.EventQueue;

import javax.swing.UIManager;
import javax.swing.JFrame;
import javax.swing.JTabbedPane;
import javax.swing.JPanel;
import javax.swing.JLabel;
import javax.swing.JTextField;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.awt.event.ActionEvent;
import javax.swing.border.LineBorder;
import javax.swing.plaf.ColorUIResource;

import utils.components.JFilePicker;

import java.awt.Color;
import java.awt.Font;

public class SmartCardSimulator {

	private JFrame frame;
	private JTextField fieldRecipientAccountId;
	private JTextField fieldAmount;
	private JTextField fieldScsPin;
	private JLabel lblMessageSingle;
	private JLabel lblMessageBatch;

	/**
	 * Launch the application.
	 */
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
					SmartCardSimulator window = new SmartCardSimulator();
					window.frame.setVisible(true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}

	/**
	 * Create the application.
	 */
	public SmartCardSimulator() {
		initialize();
	}

	/**
	 * Initialize the contents of the frame.
	 */
	private void initialize() {
		frame = new JFrame();
		frame.getContentPane().setBackground(new Color(102, 102, 102));
		frame.setBackground(Color.WHITE);
		frame.setBounds(100, 100, 450, 300);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.getContentPane().setLayout(null);
		

		UIManager.put("TabbedPane.contentAreaColor", Color.DARK_GRAY);
		UIManager.put("TabbedPane.light", ColorUIResource.GRAY);
		UIManager.put("TabbedPane.highlight", ColorUIResource.GRAY);
		UIManager.put("TabbedPane.shadow", ColorUIResource.GRAY);
		UIManager.put("TabbedPane.darkShadow", ColorUIResource.DARK_GRAY);
		UIManager.put("TabbedPane.selected", ColorUIResource.LIGHT_GRAY);
		UIManager.put("TabbedPane.borderHightlightColor", ColorUIResource.GRAY);
		
		
		JTabbedPane tabbedPane = new JTabbedPane(JTabbedPane.TOP);
		tabbedPane.setFont(new Font("Century Schoolbook L", Font.BOLD, 14));
		tabbedPane.setBackground(Color.WHITE);
		tabbedPane.setBounds(12, 12, 426, 248);
		
		frame.getContentPane().add(tabbedPane);
		
		JPanel panelSingle = new JPanel();
		panelSingle.setBackground(Color.WHITE);
		tabbedPane.addTab("Single Transaction", null, panelSingle, null);
		panelSingle.setLayout(null);
		
		JLabel lblRecipientAccountId = new JLabel("Recipient Account ID*");
		lblRecipientAccountId.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblRecipientAccountId.setBounds(23, 26, 140, 25);
		panelSingle.add(lblRecipientAccountId);
		
		JLabel lblAmount = new JLabel("Amount*");
		lblAmount.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblAmount.setBounds(23, 66, 140, 25);
		panelSingle.add(lblAmount);
		
		JLabel lblScsPin = new JLabel("SCS Pin*");
		lblScsPin.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblScsPin.setBounds(23, 106, 140, 25);
		panelSingle.add(lblScsPin);
		
		fieldRecipientAccountId = new JTextField();
		fieldRecipientAccountId.setBounds(224, 26, 140, 25);
		panelSingle.add(fieldRecipientAccountId);
		fieldRecipientAccountId.setColumns(10);
		
		fieldAmount = new JTextField();
		fieldAmount.setBounds(224, 66, 140, 25);
		panelSingle.add(fieldAmount);
		fieldAmount.setColumns(10);
		
		fieldScsPin = new JTextField();
		fieldScsPin.setBounds(224, 106, 140, 25);
		panelSingle.add(fieldScsPin);
		fieldScsPin.setColumns(10);
		
		JButton btnGenerateTanForSingle = new JButton("Generate TAN");
		btnGenerateTanForSingle.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		btnGenerateTanForSingle.setForeground(Color.WHITE);
		btnGenerateTanForSingle.setBackground(Color.DARK_GRAY);
		btnGenerateTanForSingle.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (isValidSingleTransaction()) {
					System.out.println(fieldRecipientAccountId.getText());
					System.out.println(fieldAmount.getText());
					System.out.println(fieldScsPin.getText());	
				}				
			}
		});
		btnGenerateTanForSingle.setBounds(130, 155, 154, 25);
		panelSingle.add(btnGenerateTanForSingle);
		
		lblMessageSingle = new JLabel("");
		lblMessageSingle.setBounds(23, 190, 351, 15);
		panelSingle.add(lblMessageSingle);
		
		JPanel panelBatch = new JPanel();
		panelBatch.setBackground(Color.WHITE);
		tabbedPane.addTab("Batch Transactions", null, panelBatch, null);
		panelBatch.setLayout(null);		
		
		JFilePicker filePicker = new JFilePicker("Choose a file* ", "Browse");
		filePicker.setBackground(Color.WHITE);
        filePicker.setMode(JFilePicker.MODE_OPEN);
        filePicker.setBounds(12, 55, 409, 71);    
        
        //filePicker.addFileTypeFilter(".txt", "Text Files");
        panelBatch.add(filePicker);
        
        JButton btnGenerateTanForBatch = new JButton("Generate TAN");
        btnGenerateTanForBatch.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
        btnGenerateTanForBatch.setForeground(Color.WHITE);
        btnGenerateTanForBatch.setBackground(Color.DARK_GRAY);
        btnGenerateTanForBatch.addActionListener(new ActionListener() {
        	public void actionPerformed(ActionEvent e) {
        		String filePath = filePicker.getSelectedFilePath();
        		if (filePath.trim().isEmpty()) {
        			//markFieldForError(filePicker);
        			lblMessageBatch.setText("Please choose a file.");
        		} else {
        			lblMessageBatch.setText("");
        			System.out.println(filePath);	
        		}
        	}
        });
        btnGenerateTanForBatch.setBounds(130, 155, 154, 25);
        panelBatch.add(btnGenerateTanForBatch);
        
        lblMessageBatch = new JLabel("");
        lblMessageBatch.setBounds(23, 190, 351, 15);
        panelBatch.add(lblMessageBatch);
	}
	
	/**
	 * Verifies if the all the required fields in the form are filled. 
	 */
	private Boolean isFormFilled() {
		String msgRequiredFields = "Please fill all the required fields.";		
		Boolean isFormFilled = true;
		
		fieldAmount.setBorder(null);
		fieldRecipientAccountId.setBorder(null);
		fieldScsPin.setBorder(null);
		
		/*Check if the Amount entered is empty*/
		if (fieldAmount.getText().trim().isEmpty()) {
			markFieldForError(fieldAmount);
			isFormFilled = false;
		}		
		
		/*Check if the Recipient Account Id entered is empty*/
		if (fieldRecipientAccountId.getText().trim().isEmpty()) {
			markFieldForError(fieldRecipientAccountId);
			isFormFilled = false;
		}
				
		/*Check if the SCS Pin entered is empty*/
		if (fieldScsPin.getText().trim().isEmpty()) {
			markFieldForError(fieldScsPin);
			isFormFilled = false;
		}
		/*Set appropriate error message*/ 
		if (!isFormFilled) {
			setMessage(msgRequiredFields);
		}
		return isFormFilled;				
	}
	
	/**
	 * Highlights a field to indicate error.
	 */
	private void markFieldForError(JTextField field) {
		LineBorder errorField = new LineBorder(Color.RED, 1, true);		
		field.setBorder(errorField);
	}
	
	/**
	 * Highlights a field to indicate error and also displays the message specified.
	 */
	private void markFieldForError(JTextField field, String message) {
		LineBorder errorField = new LineBorder(Color.RED, 1, true);		
		setMessage(message);
		field.setBorder(errorField);
	}
	
	/**
	 * Displays the specified message.
	 */
	private void setMessage(String message) {
		lblMessageSingle.setText(message);
	}
	
	/**
	 * Verifies if the data for the single transaction is valid.
	 */
	private Boolean isValidSingleTransaction() {						
		Pattern numeric = Pattern.compile("[0-9]*\\.?[0-9]+");
		Matcher matcher;
		
		if (isFormFilled()) {
			fieldAmount.setBorder(null);
			fieldRecipientAccountId.setBorder(null);
			fieldScsPin.setBorder(null);
			
			matcher = numeric.matcher(fieldAmount.getText().trim());
			if (matcher.matches()) {
				Float amount = Float.parseFloat(matcher.group(0));
				/*Return if the amount entered is invalid(i.e., negative or 0)*/
				if (amount <= 0) {
					markFieldForError(fieldAmount, "Incorrect Amount for the transfer");					
					return false;	
				}	
			} else {
				markFieldForError(fieldAmount, "Incorrect Amount for the transfer");
				return false;
			}
			
			matcher = numeric.matcher(fieldRecipientAccountId.getText().trim());
			if (matcher.matches()) {
				Integer recipientAccountId = Integer.parseInt(matcher.group(0));
				/*Return if the recipient account id entered is invalid(i.e., negative or 0)*/
				if (recipientAccountId <= 0) {
					markFieldForError(fieldRecipientAccountId, "Incorrect Recipient Account Id for the transfer");
					return false;
				}
			} else {
				markFieldForError(fieldRecipientAccountId, "Incorrect Recipient Account Id for the transfer");				
				return false;
			}
						
			String scsPin = fieldScsPin.getText().trim();
			/*Return if the SCS Pin entered does not contain 6 characters.*/
			if (scsPin.length() != 6) {
				markFieldForError(fieldScsPin, "Incorrect SCS Pin for the transfer");				
				return false;
			}
		
			setMessage("");
			return true;
		}
		return false;
	}
}
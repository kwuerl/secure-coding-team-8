/**
 * TanGenerator class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */

package securebank.scs.helpers;

import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class TanGenerator {
	public TanGenerator() {
		
	}
	
	public String getTan(String recipient, String amount, String scsPin) {
		String hash = generateHash(recipient + amount + scsPin);
		return getTanFromHash(hash);
	}
	
	private static String getTanFromHash(String hash) {
		hash = hash.substring(0, 15);				
		System.out.println("tan is " + hash);
		return hash;
	}

	private String generateHash(String toHash) {
		/*Create MD5 Hash*/
		MessageDigest digest = null;
		try {
			digest = MessageDigest.getInstance("SHA-512");
			digest.update(toHash.getBytes("UTF-8"));
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		byte messageDigest[] = digest.digest();
		System.out.println("digest =" + digest.digest().toString());
		/*Create Hex String*/
		StringBuffer hexString = new StringBuffer();
		for (int i = 0; i < messageDigest.length; i++) {
			hexString.append(String.format("%02x", 0xFF & messageDigest[i]));
		}
		return hexString.toString();
	}
}
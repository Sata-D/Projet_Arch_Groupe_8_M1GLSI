package com.mkyong.hashing;

import org.apache.commons.codec.digest.DigestUtils;
public class PasswordSha256 {
	public static String sha256(String password) {
		 String result = DigestUtils.sha256Hex(password);
	     return result;
	}
}

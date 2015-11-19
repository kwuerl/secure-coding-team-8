import requests
import sys
import getopt

def main(argv):
	url = ''
	data = ''
	samples = ''
	cookie_name = 'PHPSESSID'
	try:
		opts, args = getopt.getopt(argv,"hu:d:s:c:",["url=","data=","samples=","cookie_name="])
	except getopt.GetoptError:
		print 'sid_analysis.py -u <url> -d <data_urlencoded>'
		sys.exit(2)
	for opt, arg in opts:
		if opt == '-h':
			print 'sid_analysis.py -u <url> -d <data_urlencoded>'
			sys.exit()
		elif opt in ("-u", "--url"):
			url = arg
		elif opt in ("-c", "--cookie_name"):
			cookie_name = arg
		elif opt in ("-d", "--data"):
			data = arg
		elif opt in ("-s", "--samples"):
			samples = arg

	headers = {'Content-Type': 'application/x-www-form-urlencoded'}

	res_sids = []
	for x in range(0, int(samples)):
		r = requests.post(url, data=data, headers=headers)
		cookies = r.request._cookies.get_dict()
		sid = cookies[cookie_name]
		res_sids.append(sid)
		print(sid)
main(sys.argv[1:])